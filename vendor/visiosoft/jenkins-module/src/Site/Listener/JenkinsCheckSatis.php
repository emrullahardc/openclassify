<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SatisModule\Event\CheckSatisStatus;

class JenkinsCheckSatis
{
    private $site;

    public function __construct(SiteRepositoryInterface $site)
    {
        $this->site = $site;
    }

    public function handle(CheckSatisStatus $event)
    {
        $response = $this->site->checkStatusRequest($event->getqueueId(), $event->getEndpoint());

        $this->site->create([
            'type' => "satis",
            'queueId' => $event->getqueueId()
        ]);

        return $response;
    }
}
