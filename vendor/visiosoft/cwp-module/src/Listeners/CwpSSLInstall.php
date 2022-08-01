<?php namespace Visiosoft\CwpModule\Listeners;

use Anomaly\Streams\Platform\Message\MessageBag;
use Visiosoft\CwpModule\Server\Contract\ServerRepositoryInterface;
use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\InstallSSL;

class CwpSSLInstall
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

    public function handle(InstallSSL $event)
    {
        $site = $event->getSite();

        if (!$node = $this->server->findBy('node_name', $site->node)) {
            $this->messages->error(trans('visiosoft.module.cwp::message.server_not_found'));

            return false;
        } else {
            //SSL Add
            $ssl_params = [
                'action' => 'add',
                'name' => $event->getDomain()->domain,
                'user' => $site->username(),
            ];

            $ssl = $this->cwp->newRequest('autossl', $node->getApiKey(), $node->getApiUrl(), $ssl_params);

            if (!$ssl->status) {
                $this->messages->error([json_decode($ssl->response, true)['msj']]);

                return false;
            } else {
                return true;
            }
        }
    }
}
