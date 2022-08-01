<?php namespace Visiosoft\JenkinsModule\Site\Listener;

use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SatisModule\Event\UpdateSatis;

class JenkinsUpdateSatis
{
    private $site;

    public function __construct(SiteRepositoryInterface $site)
    {
        $this->site = $site;
    }

    public function handle(UpdateSatis $event)
    {
        $response = $this->site->newRequest(
            ['update' => $event->getGitPull(),],
            $event->getToken(),
            $event->getEndpoint());


        $response_link = $response->getHeader('Location')[0];
        $response_params = array_values(array_filter(explode('/', $response_link)));
        $response_id = end($response_params);

        $this->site->create([
            'type' => "satis",
            'update' => $event->getGitPull(),
            'queueId' => $response_id
        ]);

        return $response_id;
    }
}
