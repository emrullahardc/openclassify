<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Visiosoft\CustomfieldsModule\CustomField\Contract\CustomFieldRepositoryInterface;
use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\DeleteTrial;

class JenkinsDeleteTrial
{
    private $site;
    private $customFieldRepository;

    public function __construct(SiteRepositoryInterface $site, CustomFieldRepositoryInterface $customFieldRepository)
    {
        $this->site = $site;
        $this->customFieldRepository = $customFieldRepository;
    }

    public function handle(DeleteTrial $event)
    {
        $addon = $this->customFieldRepository
            ->getAdValueByCustomFieldSlug('addon_composer_name', $event->getTrial()->trialed_addon->id);
        $addon = explode('-', $addon);

        if ($app = $event->getTrial()->site->app) {
            $response = $this->site->newRequest([
                'userCWP' => $app->subdomain_name,
                'node' => $app->getServer(),
                'addon_name' => array_first($addon),
                'addonremove' => "true",
                'app' => $event->getTrial()->site->subdomain_name
            ]);
        } else {
            $response = $this->site->newRequest([
                'userCWP' => $event->getTrial()->site->subdomain_name,
                'node' => $event->getTrial()->site->getServer(),
                'addon_name' => array_first($addon),
                'addonremove' => "true",
            ]);
        }


        $response_link = $response->getHeader('Location')[0];
        $response_params = array_values(array_filter(explode('/', $response_link)));
        $response_id = end($response_params);

        $this->site->create([
            'subdomain' => $event->getTrial()->site->subdomain_name,
            'site_id' => $event->getSite()->id,
            'addon' => true,
            'addonName' => array_first($addon),
            'addonType' => end($addon),
            'delete' => true,
            'queueId' => $response_id,
        ]);

    }
}
