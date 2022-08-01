<?php namespace Visiosoft\SubscriptionsModule\Log;

use Visiosoft\SubscriptionsModule\Log\Contract\LogInterface;
use Anomaly\Streams\Platform\Model\Subscriptions\SubscriptionsLogEntryModel;

class LogModel extends SubscriptionsLogEntryModel implements LogInterface
{
    protected $ttl = false;

}
