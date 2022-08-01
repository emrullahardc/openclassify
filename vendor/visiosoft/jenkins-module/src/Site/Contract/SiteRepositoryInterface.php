<?php namespace Visiosoft\JenkinsModule\Site\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

interface SiteRepositoryInterface extends EntryRepositoryInterface
{

    /**
     * @param array $params
     * @return mixed
     */
    public function newRequest(array $params, $token = null, $endpoint = null);

    /**
     * @param $queueId
     * @return mixed
     */
    public function checkStatusRequest($queueId, $endpoint = null);

    public function showLog($job_id);
}
