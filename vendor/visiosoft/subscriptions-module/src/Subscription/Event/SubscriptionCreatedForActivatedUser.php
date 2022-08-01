<?php namespace Visiosoft\SubscriptionsModule\Subscription\Event;

class SubscriptionCreatedForActivatedUser
{
    protected $subscription;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    public function getSubscription()
    {
        return $this->subscription;
    }
}
