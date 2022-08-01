<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\UpdateSite;

class JenkinsUpdate
{
    private $site;

    public function __construct(SiteRepositoryInterface $site)
    {
        $this->site = $site;
    }

    public function handle(UpdateSite $event)
    {
        $site = $event->getSite();

        if($site->app){
            $site = $site->app;
        }

        $response = $this->site->newRequest([
            'userCWP' => $site->subdomain_name,
            'node' => $site->getServer(),
        ]);

        $response_link = $response->getHeader('Location')[0];
        $response_params = array_values(array_filter(explode('/', $response_link)));
        $response_id = end($response_params);

        $this->site->create([
            'subdomain' => $event->getSite()->subdomain_name,
            'site_id' => $event->getSite()->id,
            'update' => true,
            'queueId' => $response_id,
        ]);

    }
}
