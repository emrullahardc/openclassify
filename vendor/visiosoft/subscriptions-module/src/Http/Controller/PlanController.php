<?php namespace Visiosoft\SubscriptionsModule\Http\Controller;

use Anomaly\Streams\Platform\Http\Controller\ResourceController;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;


class PlanController extends ResourceController
{
    private $plan;
    private $subscription;

    public function __construct(
        PlanRepositoryInterface $plan,
        SubscriptionRepositoryInterface $subscription
    )
    {
        $this->plan = $plan;
        $this->subscription = $subscription;
        parent::__construct();
    }

    public function index()
    {
        $plans = $this->plan->newQuery()->get();
        $this->template->set('meta_title', trans('visiosoft.module.subscriptions::field.buy_plan'));
        return $this->view->make('visiosoft.module.subscriptions::plan.list', compact('plans'));
    }

//    public function buyPlan($id)
//    {
//        $subscription = $this->subscription->create(['assign_id' => $user->getId(),
//            'paddle_subscription_id' => $subscription_created['subscription_id'],
//            'plan_id' => $plan->id,
//            'enabled' => true]);
//    }


}
