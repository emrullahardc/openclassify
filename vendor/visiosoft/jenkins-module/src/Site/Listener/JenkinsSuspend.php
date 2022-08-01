<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\DeleteSite;
use Visiosoft\SiteModule\Site\Event\SuspendSite;

class JenkinsSuspend
{
    private $site;
    private $cwp;

    public function __construct(SiteRepositoryInterface $site, TaskRepositoryInterface $cwp)
    {
        $this->site = $site;
        $this->cwp = $cwp;
    }

    public function handle(SuspendSite $event)
    {
        if ($app = $event->getSite()->app) {
            $endpoint = "https://" . setting_value('visiosoft.module.jenkins::username') . ":" .
                setting_value('visiosoft.module.jenkins::token') . "@" .
                'jenkins.visiosoft.com.tr/job/Siteclassified/buildWithParameters';

            $response = $this->site->newRequest([
                'app' => $app->subdomain_name,
                'node' => $app->getServer(),
                'reference' => $event->getSite()->subdomain_name,
                'suspend' => ($event->getStatus() === "true") ? "true" : "false",
            ], setting_value('visiosoft.module.jenkins::token_parameter'), $endpoint);

            $response_link = $response->getHeader('Location')[0];
            $response_params = array_values(array_filter(explode('/', $response_link)));
            $response_id = end($response_params);

            $this->site->create([
                'subdomain' => $event->getSite()->subdomain_name,
                'site_id' => $event->getSite()->id,
                'suspend' => ($event->getStatus() === "true") ? true : false,
                'queueId' => $response_id,
            ]);

            return ['status' => true];

        } else {
            //Account Suspend or UnSuspend
            $response = $this->cwp->newRequest('account', null, $event->getSite()->node, [
                'action' => ($event->getStatus() === "true") ? 'susp' : 'unsp',
                'user' => $event->getSite()->subdomain_name,
            ]);

            if ($response->status) {
                return ['status' => true];
            }
            return [
                'status' => false,
                'message' => json_decode($response->response, true)['msj']
            ];
        }
    }
}
