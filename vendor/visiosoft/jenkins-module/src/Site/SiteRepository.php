<?php namespace Visiosoft\JenkinsModule\Site;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use http\Exception;
use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class SiteRepository extends EntryRepository implements SiteRepositoryInterface
{
    /**
     * @var SiteModel
     */
    protected $model;
    /**
     * @var \Anomaly\Streams\Platform\Addon\FieldType\FieldType
     */
    private $username;
    /**
     * @var \Anomaly\Streams\Platform\Addon\FieldType\FieldType
     */
    private $token;
    /**
     * @var \Anomaly\Streams\Platform\Addon\FieldType\FieldType
     */
    private $url;
    /**
     * @var \Anomaly\Streams\Platform\Addon\FieldType\FieldType
     */
    private $token_parameter;
    /**
     * @var string
     */
    private $endpoint;
    /**
     * @var \Anomaly\Streams\Platform\Addon\FieldType\FieldType
     */
    private $check_url;

    /**
     * SiteRepository constructor.
     * @param SiteModel $model
     */
    public function __construct(SiteModel $model)
    {
        $this->model = $model;
        $this->username = setting_value('visiosoft.module.jenkins::username');
        $this->token = setting_value('visiosoft.module.jenkins::token');
        $this->url = setting_value('visiosoft.module.jenkins::url');
        $this->check_url = setting_value('visiosoft.module.jenkins::control_url');
        $this->token_parameter = setting_value('visiosoft.module.jenkins::token_parameter');

        $this->endpoint = "https://" . $this->username . ":" . $this->token . "@" . $this->url;
    }

    /**
     * @param array $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function newRequest(array $params, $token = null, $endpoint = null)
    {
        $params = array_merge($params, [
            'token' => (!is_null($token)) ? $token : $this->token_parameter
        ]);

        $client = new \GuzzleHttp\Client(['verify' => false]);

        $response = $client->request('POST', (!is_null($endpoint)) ? $endpoint : $this->endpoint, ['query' => $params]);

        return $response;
    }

    /**
     * @param $queueId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkStatusRequest($queueId, $endpoint = null)
    {
        if (is_null($endpoint)) {
            $endpoint = "https://" . $this->username . ":" . $this->token . "@" .
                $this->check_url . "&xpath=//build[queueId=" . $queueId . "]";
        }

//        $client = new \GuzzleHttp\Client();


        $client = new Client([
            'cookies' => true,
            'http_errors' => false,
            'verify' => false
        ]);

        $response = $client->request('GET', $endpoint);
        if ($code = $response->getStatusCode() == 200) {
            $xml = simplexml_load_string($response->getBody()->getContents(), "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $response = json_decode($json, TRUE);
            return $response;
        }
        return null;
    }

    public function showLog($job_id)
    {
        return file_get_contents("https://".$this->username.":".$this->token."@ci.visiosoft.com.tr/job/autoclassified%20CWP/".$job_id."/consoleText", false, stream_context_create(["ssl" => ["verify_peer"=>false, "verify_peer_name"=>false]]));
    }
}
