<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\CheckActivatedSite;

class JenkinsCheckActivated
{
    /**
     * @var SiteRepositoryInterface
     */
    private $site;

    /**
     * JenkinsCheckActivated constructor.
     * @param SiteRepositoryInterface $site
     */
    public function __construct(SiteRepositoryInterface $site)
    {
        $this->site = $site;
    }

    /**
     * @param CheckActivatedSite $event
     * @return mixed
     */
    public function handle(CheckActivatedSite $event)
    {
        $jenkins_log = $this->site->newQuery()
            ->where('subdomain', $event->getSite()
                ->subdomain_name)
            ->where('create',true)
            ->orderByDesc('id')->first();

        if ($jenkins_log) {
            $rID = $jenkins_log->queueId;

            if ($event->getSite()->app) {
                $endpoint = $endpoint = "https://" . setting_value('visiosoft.module.jenkins::username') .
                    ":" . setting_value('visiosoft.module.jenkins::token') .
                    "@jenkins.visiosoft.com.tr/job/Siteclassified/api/xml?tree=builds[id,number,result,queueId]&xpath=//build[queueId="
                    . $rID . "]";

                $response = $this->site->checkStatusRequest($rID, $endpoint);
            } else {
                $response = $this->site->checkStatusRequest($rID);
            }

            if ($response and isset($response['result']) and $response['result'] == "SUCCESS") {
                return true;
            }
        }
        return false;
    }
}
