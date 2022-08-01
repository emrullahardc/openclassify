<?php namespace Visiosoft\SubscriptionsModule\Subscription\Event;

use Visiosoft\SubscriptionsModule\Plan\PlanModel;

class RemainingSubscription
{
    /**
     * @author Visiosoft LTD.
     */
    private $subscription;
    private $remaining;

    /**
     * SubscriptionChanged constructor.
     * @param $subscription
     */
    public function __construct($remaining, $subscription)
    {
        $this->subscription = $subscription;
        $this->remaining = $remaining;
    }

    /**
     * @return mixed
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    public function getPlan()
    {
        $plan = new PlanModel();
        return $plan->newQuery()->find($this->getSubscription()->plan_id);
    }

    public function getRemaining()
    {
        return $this->remaining;
    }
}
