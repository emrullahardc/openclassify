<?php namespace Visiosoft\CwpModule\Server;

use Visiosoft\CwpModule\Server\Contract\ServerInterface;
use Anomaly\Streams\Platform\Model\Cwp\CwpServerEntryModel;

class ServerModel extends CwpServerEntryModel implements ServerInterface
{
    public function getApiUrl()
    {
        return $this->api_url;
    }

    public function getApiKey()
    {
        return $this->api_key;
    }
}
