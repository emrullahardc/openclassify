<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\BuildSite;
use Visiosoft\SiteModule\Site\Event\BuildSubSite;

class JenkinsCreateSubSite
{
    private $site;
    private $cwp;

    public function __construct(SiteRepositoryInterface $site, TaskRepositoryInterface $cwp)
    {
        $this->site = $site;
        $this->cwp = $cwp;
    }

    public function handle(BuildSubSite $event)
    {
        try {

            $domain = $this->createDomain($event->getSite());

            if(!$domain['status'])
            {
                return $domain;
            }

            $app = $event->getApp();

            $endpoint = "https://" . setting_value('visiosoft.module.jenkins::username') . ":" .
                setting_value('visiosoft.module.jenkins::token') . "@" .
                'jenkins.visiosoft.com.tr/job/Siteclassified/buildWithParameters';

            $response = $this->site->newRequest([
                'app' => $app->username(),
                'domain' => $event->getSubdomain() . "." . $event->getType(),
                'subdomain' => $event->getSubdomain(),
                'node' => $app->getServer(),
                'username' => $event->getUser()->username,
                'locale' => $event->getSite()->getLocale(),
                'password' => $event->getPassword(),
                'email' => $event->getUser()->email,
            ], setting_value('visiosoft.module.jenkins::token_parameter'), $endpoint);

            $response_link = $response->getHeader('Location')[0];
            $response_params = array_values(array_filter(explode('/', $response_link)));
            $response_id = end($response_params);

            $this->site->create([
                'subdomain' => $event->getSubdomain(),
                'site_id' => $event->getSite()->id,
                'email' => $event->getUser()->email,
                'username' => $event->getUser()->username,
                'password' => $event->getPassword(),
                'create' => true,
                'queueId' => $response_id,
            ]);

            return ['status' => true];

        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function createDomain($site)
    {
        //Add Domain Account
        $domain = $this->cwp->newRequest('admindomains',null,$site->node, [
            'action' => 'add',
            'user' => $site->app->subdomain_name,
            'type' => 'domain',
            'name' => $site->subdomain_name . "." . $site->type,
            'path' => '/public_html',
            'autossl' => "0",
        ]);

        $response = json_decode($domain->response, true);

        //Domain eklemesi başarılı
        if ($response && isset($response['status']) and $response['status'] == "OK") {

            //Add SSL For Domain
            $ssl = $this->cwp->newRequest('autossl', null,$site->node,[
                'action' => 'add',
                'user' => $site->app->subdomain_name,
                'name' => $site->subdomain_name . "." . $site->type,
            ]);

            $response = json_decode($ssl->response, true);

            //ssl kurulumu başarılı
            if ($response['status'] == "OK") {
                return ['status' => true];
            }
            return ['status' => false, 'message' => $response['msj']];
        }
        return ['status' => false, 'message' => $response['msj']];
    }
}
