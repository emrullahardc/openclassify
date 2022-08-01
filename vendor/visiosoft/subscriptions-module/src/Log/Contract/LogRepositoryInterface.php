<?php namespace Visiosoft\SubscriptionsModule\Log\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

interface LogRepositoryInterface extends EntryRepositoryInterface
{

    public function getLogForParams($params);

    public function getFirstRemainingLog($subscription_id, $remaining);

    public function getFirstSuspendLog($subscription_id);

    public function createRemainingLog($subscription, $remaining);

    public function createSuspendLog($subscription);
}
