<?php namespace Visiosoft\SubscriptionsModule\Subscription\Event;

use Visiosoft\SubscriptionsModule\Plan\PlanModel;

class ExpiredSubscription
{
    /**
     * @author Visiosoft LTD.
     */
    private $subscription;

    /**
     * SubscriptionChanged constructor.
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

    public function getPlan()
    {
        $plan = new PlanModel();
        return $plan->newQuery()->find($this->getSubscription()->plan_id);
    }
}
