<?php namespace Visiosoft\CwpModule\Server\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

interface ServerInterface extends EntryInterface
{
    public function getApiUrl();

    public function getApiKey();
}
