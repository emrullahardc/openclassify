<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\CheckCompletedAddonInstall;

class JenkinsCheckAddonInstall
{

    private $site;

    public function __construct(SiteRepositoryInterface $site)
    {
        $this->site = $site;
    }

    public function handle(CheckCompletedAddonInstall $event)
    {
        $addon_slug = explode("-", $event->getAddon());
        $site = $this->site->newQuery()
            ->where('subdomain', $event->getSite()->subdomain_name)
            ->where('addon', true)
            ->where('addonName', array_first($addon_slug))
            ->where('addonType', end($addon_slug))
            ->orderByDesc('id')->first();

        if ($site) {
            $rID = $site->queueId;
            $response = $this->site->checkStatusRequest($rID);

            if (!is_null($response) and isset($response['result']) and $response['result'] == "SUCCESS") {
                return true;
            }
        }
        return false;
    }
}
