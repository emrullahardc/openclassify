<?php namespace Visiosoft\SubscriptionsModule\Subscription;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryObserver;

class SubscriptionObserver extends EntryObserver
{
    public function created(EntryInterface $entry)
    {
        $entry->calculateExtend();
        parent::created($entry);
    }
}
