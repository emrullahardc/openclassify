<?php namespace Visiosoft\SubscriptionsModule\Subscription\Listener;

use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Visiosoft\ProfileModule\Events\UserActivatedBySmsEvent;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Event\SubscriptionCreatedForActivatedUser;

class ActivatedUserBySmsListener
{
    private $plan;
    private $user;
    private $subscription;

    public function __construct(
        PlanRepositoryInterface         $plan,
        UserRepositoryInterface         $user,
        SubscriptionRepositoryInterface $subscription)
    {
        $this->plan = $plan;
        $this->user = $user;
        $this->subscription = $subscription;
    }

    public function handle(UserActivatedBySmsEvent $event)
    {
        if (is_module_installed('visiosoft.module.site')) {
            $default_plan = setting_value('visiosoft.module.subscriptions::register_default_plan');
            if ($plan = $this->plan->find($default_plan)) {
                $subscription = $this->subscription->createNew($event->getUser()->getId(), $plan, false);
                event(new SubscriptionCreatedForActivatedUser($subscription));
            }
        }
    }
}
