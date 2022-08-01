<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Anomaly\Streams\Platform\Message\MessageBag;
use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\DeleteSite;

class JenkinsDelete
{
    private $site;
    private $cwp;
    private $message;

    public function __construct(SiteRepositoryInterface $site, TaskRepositoryInterface $cwp, MessageBag $message)
    {
        $this->site = $site;
        $this->message = $message;
        $this->cwp = $cwp;
    }

    public function handle(DeleteSite $event)
    {
        //Delete Account
        if ($app = $event->getSite()->app) {

            $domain = $this->cwp->newRequest('admindomains', null, $event->getSite()->node, [
                'action' => 'del',
                'CURLOPT_TIMEOUT' => 3000,
                'user' => $app->subdomain_name,
                'type' => 'domain',
                'name' => $event->getSite()->subdomain_name . "." . $event->getSite()->type,
            ]);

            $response = json_decode($domain->response, true);

            if ($response) {
                if ($response['status'] != "OK") {
                    return ['status' => false, 'message' => $response['msj']];
                }
            } else {
                return ['status' => false, 'message' => trans('streams::message.no_results')];
            }

            $endpoint = "https://" . setting_value('visiosoft.module.jenkins::username') . ":" .
                setting_value('visiosoft.module.jenkins::token') . "@" .
                'jenkins.visiosoft.com.tr/job/Siteclassified/buildWithParameters';

            $response = $this->site->newRequest([
                'app' => $app->subdomain_name,
                'node' => $app->getServer(),
                'reference' => $event->getSite()->subdomain_name,
                'delete' => "true"
            ], setting_value('visiosoft.module.jenkins::token_parameter'), $endpoint);

            $response_link = $response->getHeader('Location')[0];
            $response_params = array_values(array_filter(explode('/', $response_link)));
            $response_id = end($response_params);

            $this->site->create([
                'subdomain' => $event->getSite()->subdomain_name,
                'site_id' => $event->getSite()->id,
                'delete' => true,
                'queueId' => $response_id,
            ]);

            return ['status' => true];

        } else {
            $response = $this->cwp->newRequest('account', null, $event->getSite()->node, [
                'action' => 'del',
                'user' => $event->getSite()->subdomain_name
            ]);

            $response = isset($response->response) ? json_decode($response->response, true) : $response;

            if (isset($response['status']) && $response['status'] == "OK") {
                return ['status' => true];
            }
            return ['status' => false, 'message' => $response['msj']];
        }
    }
}
