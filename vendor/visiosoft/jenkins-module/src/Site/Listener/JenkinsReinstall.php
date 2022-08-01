<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Anomaly\Streams\Platform\Message\MessageBag;
use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\BuildSite;
use Visiosoft\SiteModule\Site\Event\DeleteSite;
use Visiosoft\SiteModule\Site\Event\ReinstallSite;

class JenkinsReinstall
{
    private $site;
    private $cwp;
    private $message;

    public function __construct(SiteRepositoryInterface $site, TaskRepositoryInterface $cwp, MessageBag $message)
    {
        $this->site = $site;
        $this->cwp = $cwp;
        $this->message = $message;
    }

    public function handle(ReinstallSite $event)
    {
        $site = $event->getSite();
        $response = array_first(event(new DeleteSite($site)));

        if ($response['status']) {
            //New Create Account
            return array_first(event(new BuildSite($site)));
        }
        return $response;
    }
}
