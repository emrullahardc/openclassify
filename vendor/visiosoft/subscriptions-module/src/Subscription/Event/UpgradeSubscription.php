<?php namespace Visiosoft\SubscriptionsModule\Subscription\Event;

class UpgradeSubscription
{

    private $old_subscription;
    private $new_subscription;

    public function __construct($old_subscription, $new_subscription)
    {
        $this->old_subscription = $old_subscription;
        $this->new_subscription = $new_subscription;
    }

    public function getOldSubscription()
    {
        return $this->old_subscription;
    }

    public function getNewSubscription()
    {
        return $this->new_subscription;
    }
}
