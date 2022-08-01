<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Anomaly\Streams\Platform\Message\MessageBag;
use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SiteModule\Domain\Event\DeleteDomain;

class JenkinsDeleteDomainSite
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

    public function handle(DeleteDomain $event)
    {
        //Delete Domain
        if ($app = $event->getSite()->app) {
            $domain = $this->cwp->newRequest('admindomains', null, $app->node, [
                'action' => 'del',
                'user' => $app->subdomain_name,
                'CURLOPT_TIMEOUT' => 3000,
                'type' => 'domain',
                'name' => $event->getDomain()->domain,
            ]);

            $endpoint = "https://" . setting_value('visiosoft.module.jenkins::username') . ":" .
                setting_value('visiosoft.module.jenkins::token') . "@" .
                'jenkins.visiosoft.com.tr/job/Siteclassified/buildWithParameters';

            $response = $this->site->newRequest([
                'app' => $app->subdomain_name,
                'node' => $app->getServer(),
                'domain' => $event->getDomain()->domain,
                'reference' => $event->getSite()->subdomain_name,
                'removeDomain' => "true"
            ], setting_value('visiosoft.module.jenkins::token_parameter'), $endpoint);

            $response_link = $response->getHeader('Location')[0];
            $response_params = array_values(array_filter(explode('/', $response_link)));
            $response_id = end($response_params);

            $this->site->create([
                'subdomain' => $event->getSite()->subdomain_name,
                'site_id' => $event->getSite()->id,
                'delete' => true,
                'type_domain' => true,
                'queueId' => $response_id,
            ]);
        } else {
            $domain = $this->cwp->newRequest('admindomains', null, $event->getSite()->node, [
                'action' => 'del',
                'CURLOPT_TIMEOUT' => 3000,
                'user' => $event->getSite()->subdomain_name,
                'type' => 'domain',
                'name' => $event->getDomain()->domain,
            ]);
        }
        $response = json_decode($domain->response, true);

        //Domain silinmesi başarılı
        if ($response) {
            if ($response['status'] == "OK") {
                return ['status' => true];
            }

            return ['status' => false, 'message' => $response['message']];
        }
        return ['status' => false, 'message' => trans('streams::message.no_results')];
    }
}
