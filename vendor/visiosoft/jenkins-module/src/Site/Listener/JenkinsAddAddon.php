<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\AddAddonSite;

class JenkinsAddAddon
{
    protected $site;

    public function __construct(SiteRepositoryInterface $site)
    {
        $this->site = $site;
    }

    public function handle(AddAddonSite $event)
    {
        $addon_slug = explode('-', $event->getAddonSlug());

        $site = $event->getSite();

        if ($app = $site->app) {
            $response = $this->site->newRequest([
                'userCWP' => $app->subdomain_name,
                'node' => $app->getServer(),
                'addon_name' => array_first($addon_slug),
                'addon_type' => end($addon_slug),
                'app' => $site->subdomain_name
            ]);
        } else {
            $response = $this->site->newRequest([
                'userCWP' => $event->getSite()->subdomain_name,
                'node' => $event->getSite()->getServer(),
                'addon_name' => array_first($addon_slug),
                'addon_type' => end($addon_slug),
            ]);
        }
        $response_link = $response->getHeader('Location')[0];
        $response_params = array_values(array_filter(explode('/', $response_link)));
        $response_id = end($response_params);

        $this->site->create([
            'subdomain' => $event->getSite()->subdomain_name,
            'site_id' => $event->getSite()->id,
            'addon' => true,
            'addonName' => array_first($addon_slug),
            'addonType' => end($addon_slug),
            'queueId' => $response_id,
        ]);

        return true;
    }
}
