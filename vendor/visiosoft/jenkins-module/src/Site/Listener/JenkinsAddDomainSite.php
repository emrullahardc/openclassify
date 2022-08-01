<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Anomaly\Streams\Platform\Message\MessageBag;
use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Domain\Event\CreateDomain;

class JenkinsAddDomainSite
{
    private $site;
    private $cwp;
    private $message;

    public function __construct(SiteRepositoryInterface $site, TaskRepositoryInterface $cwp, MessageBag $message)
    {
        $this->site = $site;
        $this->message = $message;
        $this->cwp = $cwp;
    }

    public function handle(CreateDomain $event)
    {
        //TODO Review and Code Flush

        $site = $event->getSite();

        if ($app = $site->app) {
            $domain = $this->cwp->newRequest('admindomains', null, $app->node, [
                'action' => 'add',
                'user' => $app->subdomain_name,
                'type' => 'domain',
                'name' => $event->getDomain(),
                'path' => '/public_html',
                'autossl' => "0",
            ]);
        } else {
            $domain = $this->cwp->newRequest('admindomains', null, $event->getSite()->node, [
                'action' => 'add',
                'user' => $event->getSite()->subdomain_name,
                'type' => 'domain',
                'name' => $event->getDomain(),
                'path' => '/public_html',
                'autossl' => "0",
            ]);
        }

        $response = json_decode($domain->response, true);

        //Domain eklemesi başarılı
        if ($response && isset($response['status']) and $response['status'] == "OK") {

            //Add SSL For Domain

            if ($app = $event->getSite()->app) {
                $ssl = $this->cwp->newRequest('autossl', null, $app->node, [
                    'action' => 'add',
                    'user' => $app->subdomain_name,
                    'name' => $event->getDomain(),
                ]);
            } else {
                $ssl = $this->cwp->newRequest('autossl', null, $event->getSite()->node, [
                    'action' => 'add',
                    'user' => $event->getSite()->subdomain_name,
                    'name' => $event->getDomain(),
                ]);
            }
            $response = json_decode($ssl->response, true);

            //ssl kurulumu başarılı
            if ($response['status'] == "OK") {

                if ($app = $event->getSite()->app) {

                    $endpoint = "https://" . setting_value('visiosoft.module.jenkins::username') . ":" .
                        setting_value('visiosoft.module.jenkins::token') . "@" .
                        'jenkins.visiosoft.com.tr/job/Siteclassified/buildWithParameters';

                    $response = $this->site->newRequest([
                        'app' => $app->subdomain_name,
                        'addDomain' => "true",
                        'node' => $app->getServer(),
                        'reference' => $event->getSite()->subdomain_name,
                        'domain' => $event->getDomain(),
                    ], setting_value('visiosoft.module.jenkins::token_parameter'), $endpoint);

                    $response_link = $response->getHeader('Location')[0];
                    $response_params = array_values(array_filter(explode('/', $response_link)));
                    $response_id = end($response_params);

                    $this->site->create([
                        'subdomain' => $event->getSite()->subdomain_name,
                        'site_id' => $event->getSite()->id,
                        'create' => true,
                        'type_domain' => true,
                        'queueId' => $response_id,
                    ]);
                }

                return ['status' => true];
            }
            return ['status' => false, 'message' => $response['msj']];
        }
        return ['status' => false, 'message' => $response['msj']];
    }
}
