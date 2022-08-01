<?php namespace Visiosoft\CwpModule\Listeners;

use Anomaly\Streams\Platform\Message\MessageBag;
use Visiosoft\CwpModule\Server\Contract\ServerRepositoryInterface;
use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\CheckSubdomain;
use Visiosoft\SiteModule\Site\Event\InstallSSL;

class CwpCheckAccount
{
    protected $cwp;
    protected $server;
    protected $messages;

    public function __construct(TaskRepositoryInterface $cwp, ServerRepositoryInterface $server, MessageBag $messages)
    {
        $this->cwp = $cwp;
        $this->server = $server;
        $this->messages = $messages;
    }

    public function handle(CheckSubdomain $event)
    {
        $site = $event->getSite();

        $status = $this->cwp->checkAccount($site);

        return $status;
    }
}
