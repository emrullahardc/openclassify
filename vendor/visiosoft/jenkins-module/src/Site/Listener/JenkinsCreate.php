<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\BuildSite;

class JenkinsCreate
{
    private $site;
    private $cwp;

    public function __construct(SiteRepositoryInterface $site, TaskRepositoryInterface $cwp)
    {
        $this->site = $site;
        $this->cwp = $cwp;
    }

    public function handle(BuildSite $event)
    {
        try {
            $cwp = $this->cwp->newSiteAndDatabase(
                $event->getSite()->node,
                $event->getSubdomain(),
                $event->getUser()->username,
                $event->getUser()->email,
                $event->getType(),
                $event->getSite()
            );

            if ($cwp['account_status'] and $cwp['database_status'] and $cwp['database_user_status']) {
                $response = $this->site->newRequest([
                    'userCWP' => $cwp['username'],
                    'node' => $event->getSite()->getServer(),
                    'projectUrl' => $event->getType(),
                    'newInstallation' => "true",
                    'locale' => $event->getSite()->getLocale(),
                    'adminUserName' => $event->getUser()->username,
                    'adminPass' => $event->getPassword(),
                    'adminEmail' => $event->getUser()->email,
                    'dbUser' => $cwp['username'] . "_" . $cwp['username'],//New Created DB User
                    'dbPass' => $cwp['pass'],
                    'dbName' => $cwp['database'],
                    'autoToken' => $event->getToken()
                ]);

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
                $cwp['status'] = true;
                return $cwp;
            } else {
                $cwp['status'] = false;
                return $cwp;
            }
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
