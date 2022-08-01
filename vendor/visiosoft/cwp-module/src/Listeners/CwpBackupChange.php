<?php namespace Visiosoft\CwpModule\Listeners;

use Anomaly\Streams\Platform\Message\MessageBag;
use Visiosoft\CwpModule\Server\Contract\ServerRepositoryInterface;
use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\SiteModule\Site\Event\BackupStatusChange;

class CwpBackupChange
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

    public function handle(BackupStatusChange $event)
    {
        $site = $event->getSite();

        if (!$node = $this->server->findBy('node_name', $site->node)) {
            $this->messages->error(trans('visiosoft.module.cwp::message.server_not_found'));
        } else {
            if (!$site->assign) {
                $this->messages->error(trans('visiosoft.module.cwp::message.found_user'));
            }

            $backup_status = ($site->backup_status) ? 'on' : 'off';

            //Change Backup
            $close_backup_params = [
                'action' => 'udp',
                'user' => $site->subdomain_name,
                'email' => $site->assign->email,
                'package' => 'default',
                'backup' => $backup_status,
                'inode' => '0',
                'limit_nproc' => '40',
                'limit_nofile' => '150',
                'server_ips' => $node->server_ip,
            ];

            $this->cwp->newRequest('account', $node->getApiKey(), $node->getApiUrl(), $close_backup_params);

        }
    }
}
