<?php namespace Visiosoft\CwpModule\Task;

use Anomaly\Streams\Platform\Message\MessageBag;
use Visiosoft\CwpModule\Server\Contract\ServerRepositoryInterface;
use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class TaskRepository extends EntryRepository implements TaskRepositoryInterface
{

    protected $model;
    protected $message;

    public function __construct(TaskModel $model, MessageBag $message)
    {
        $this->model = $model;
        $this->message = $message;
    }

    public function newRequest($function, $key, $url_or_node, $params = [])
    {
        if (is_null($key)) {
            $server_repo = app(ServerRepositoryInterface::class);

            if (!$node = $server_repo->findBy('node_name', $url_or_node)) {
                $return_params['msj'] = trans('visiosoft.module.cwp::message.server_not_found');
                return $return_params;
            }
            $url_or_node = $node->getApiUrl();
            $key = $node->getApiKey();
        }

        $params = array_merge($params, ['key' => $key]);
        $newTask = $this->createRequest($function, $params);

        $url = $url_or_node . $function;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        if (!empty($params['CURLOPT_TIMEOUT']) && $params['CURLOPT_TIMEOUT'] > 500) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $params['CURLOPT_TIMEOUT']);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_POST, 1);

        try {
            $rawResponse = curl_exec($ch);
            $response = $rawResponse;
        } catch (\Exception $exception) {
            $exception->getMessage();
        }

        curl_close($ch);

        json_decode($response);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $pattern = '
/
\{              # { character
    (?:         # non-capturing group
        [^{}]   # anything that is not a { or }
        |       # OR
        (?R)    # recurses the entire pattern
    )*          # previous group zero or more times
\}              # } character
/x
';

            preg_match_all($pattern, $response, $matches);
            if (!empty($matches)) {
                if (!empty($matches[0])) {
                    if (!$matches[0][0]) {
                        $response = $matches[0][0];
                    }
                }
            }
        }

        if ($response) {
            $response = $this->getResponseJson($rawResponse);
            $response .= ($function == "usermysql") ? "}" : "";//Fix For usermysql response

            $status = false;
            if ($response !== "") {
                if (($tmpResponse = json_decode($response, true)) && $tmpResponse['status'] == "OK") {
                    $status = true;
                } elseif (($tmpResponse = json_decode($rawResponse)) && $tmpResponse->status === 'OK') {
                    $status = true;
                    $response = json_encode([
                        'status' => $tmpResponse->status,
                    ]);
                }
            }

            $newTask->update([
                'response' => $response,
                'status' => $status,
            ]);
        } else {
            $this->message->error(trans('visiosoft.module.cwp::message.error_response', ['response' => $rawResponse]));
        }

        return $newTask;
    }

    public function createRequest($function, $request)
    {
        return $this->create([
            'function' => $function,
            'request' => json_encode($request),
        ]);
    }

    public function newSiteAndDatabase($node_name, $domain, $username, $email, $type, $site = null)
    {
        $server_repo = app(ServerRepositoryInterface::class);

        if (!$node = $server_repo->findBy('node_name', $node_name)) {
            $return_params['message'] = trans('visiosoft.module.cwp::message.server_not_found');
            return $return_params;
        }

        //Create Account
        $return_params = [
            'username' => $domain,
            'email' => $email,
            'domain' => $domain . "." . $type,
            'pass' => str_random(8),
            'database' => $domain . "_" . substr($domain, 0, 3),
            'account_status' => false,
            'database_status' => false,
            'ssl_status' => false,
            'message' => "",
        ];

        if (strlen($domain) > 8) {
            $return_params['message'] = trans('module::message.username_max_characters_msg');
            return $return_params;
        }

        $account_params = [
            'action' => 'add',
            'domain' => $return_params['domain'],
            'user' => $return_params['username'],
            'pass' => $return_params['pass'],
            'email' => $email,
            'package' => 'default',
            'backup' => '0',
            'lang' => 'en',
            'inode' => '0',
            'limit_nproc' => '40',
            'limit_nofile' => '150',
            'server_ips' => $node->server_ip,
        ];

        $account = $this->newRequest('account', $node->getApiKey(), $node->getApiUrl(), $account_params);

        //Close Backup
        $close_backup_params = [
            'action' => 'udp',
            'user' => $return_params['username'],
            'email' => $email,
            'package' => 'default',
            'backup' => 'off',
            'inode' => '0',
            'limit_nproc' => '40',
            'limit_nofile' => '150',
            'server_ips' => $node->server_ip,
        ];

        $close_backup_params = $this->newRequest('account', $node->getApiKey(), $node->getApiUrl(), $close_backup_params);

        $return_params['log_account_id'] = $account->getId();
        $return_params['account_status'] = $account->status;
        $return_params['message'] .=
            ($account->status) ? '' : json_decode($account->response, true)['msj'];

        if ($account->status) {
            //Create Database
            $database_params = [
                'action' => 'add',
                'user' => $return_params['username'],
                'database' => substr($return_params['username'], 0, 3),
            ];
            $database = $this->newRequest('databasemysql', $node->getApiKey(), $node->getApiUrl(), $database_params);
            $return_params['log_database_id'] = $database->getId();
            $return_params['database_status'] = $database->status;
            $return_params['message'] .=
                ($database->status) ? '' : json_decode($database->response, true)['msj'];


            //Create DB User
            if ($database->status) {
                $database_user_params = [
                    'action' => 'add',
                    'userdb' => $return_params['username'],
                    'user' => $return_params['username'],
                    'pass' => $return_params['pass'],
                    'dbase' => substr($return_params['username'], 0, 3),
                    'host' => 'localhost',
                ];

                $database_user = $this->newRequest('usermysql', $node->getApiKey(), $node->getApiUrl(), $database_user_params);
                $return_params['log_database_user_id'] = $database_user->getId();
                $return_params['database_user_status'] = $database_user->status;
                $return_params['message'] .=
                    ($database_user->status) ? '' : json_decode($database_user->response, true)['msj'];
            }

//
//            //SSL Add
//            $ssl_params = [
//                'action' => 'add',
//                'name' => $domain,
//                'user' => $username,
//            ];
//            $ssl = $this->newRequest('autossl', $ssl_params);
//            $return_params['log_ssl_id'] = $ssl->getId();
//            $return_params['ssl_status'] = $ssl->status;
//            $return_params['message'] .=
//                ($ssl->status) ? '' : json_decode($ssl->response, true)['msj'];

        }
        return $return_params;
    }

    public function getResponseJson($response)
    {
        if ($response) {
            $pattern = '/"(status)":("(\\"|[^"])*"|\[("(\\"|[^"])*"(,"(\\"|[^"])*")*)?\])/';
            return (preg_match($pattern, $response, $match)) ? "{" . $match[0] . "}" : '';
        } else {
            return json_encode([
                'status' => 'error',
                'message' => trans('module::message.no_answer_returned')
            ]);
        }
    }

    public function checkAccount($site)
    {
        $account_params = [
            'action' => 'list',
            'user' => $site->subdomain_name
        ];

        $server_repo = app(ServerRepositoryInterface::class);

        if (!$node = $server_repo->findBy('node_name', $site->node)) {
            $return_params['message'] = trans('visiosoft.module.cwp::message.server_not_found');
            return $return_params;
        }

        $response = $this->newRequest('accountdetail', $node->getApiKey(), $node->getApiUrl(), $account_params);

        return $response->status;
    }

}
