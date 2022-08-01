<?php namespace Visiosoft\SubscriptionsModule\Subscription\Event;

class SuspendedSubscription
{
    /**
     * @author Visiosoft LTD.
     */
    private $subscription;

    /**
     * @param $subscription
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * @return mixed
     */
    public function getSubscription()
    {
        return $this->subscription;
    }



}
