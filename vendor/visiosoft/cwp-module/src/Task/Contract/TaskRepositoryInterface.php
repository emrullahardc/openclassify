<?php namespace Visiosoft\CwpModule\Task\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

interface TaskRepositoryInterface extends EntryRepositoryInterface
{
    public function newRequest($function, $key, $url_or_node, $params = []);

    public function createRequest($function, $request);

    public function newSiteAndDatabase($node_name, $domain, $username, $email, $type, $site = null);

    public function getResponseJson($response);

    public function checkAccount($site);
}
