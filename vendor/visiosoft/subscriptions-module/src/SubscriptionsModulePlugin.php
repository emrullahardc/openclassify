<?php namespace Visiosoft\SubscriptionsModule;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Illuminate\Support\Facades\Auth;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;

class SubscriptionsModulePlugin extends Plugin
{
    public $subscription;
    public $plan;

    public function __construct(SubscriptionRepositoryInterface $subscription, PlanRepositoryInterface $plan)
    {
        $this->subscription = $subscription;
        $this->plan = $plan;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'findPlan',
                function ($id) {
                    if (!$plan = $this->plan->find($id)) {
                        return null;
                    }
                    return $plan;
                }
            ),
            new \Twig_SimpleFunction(
                'getPlans',
                function () {
                    if (!$plan = $this->plan->newQuery()->get()) {
                        return null;
                    }
                    return $plan;
                }
            ),
            new \Twig_SimpleFunction(
                'getSubscriptions',
                function () {
                    if (!$subscriptions = $this->subscription->getByAssign(Auth::id())) {
                        return null;
                    }
                    return $subscriptions;
                }
            ),
        ];
    }
}
