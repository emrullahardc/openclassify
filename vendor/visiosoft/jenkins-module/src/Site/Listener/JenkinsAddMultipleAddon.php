<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\AddMultipleAddonSite;

class JenkinsAddMultipleAddon
{
    protected $site;

    public function __construct(SiteRepositoryInterface $site)
    {
        $this->site = $site;
    }

    public function handle(AddMultipleAddonSite $event)
    {
        $addon_array = json_encode($event->getAddonArray());

        $site = $event->getSite();

        if ($app = $site->app) {
            $response = $this->site->newRequest([
                'userCWP' => $app->subdomain_name,
                'node' => $app->getServer(),
                'addonarray' => $addon_array,
                'app' => $site->subdomain_name,
            ]);
        } else {
            $response = $this->site->newRequest([
                'userCWP' => $site->subdomain_name,
                'node' => $site->getServer(),
                'addonarray' => $addon_array,
            ]);
        }

        $response_link = $response->getHeader('Location')[0];
        $response_params = array_values(array_filter(explode('/', $response_link)));
        $response_id = end($response_params);

        foreach ($event->getAddonArray() as $addon) {
            $this->site->create([
                'subdomain' => $event->getSite()->subdomain_name,
                'site_id' => $event->getSite()->id,
                'addon' => true,
                'addonName' => $addon['name'],
                'addonType' => $addon['type'],
                'queueId' => $response_id,
            ]);
        }

        return true;
    }
}
