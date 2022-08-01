<?php namespace Visiosoft\SubscriptionsModule\Subscription\Command;

use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Event\SubscriptionCreatedForActivatedUser;

class RegisteredUserBySubscription
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle(PlanRepositoryInterface $planRepository, SubscriptionRepositoryInterface $subscriptionRepository)
    {
        if (is_module_installed('visiosoft.module.site')) {
            $default_plan = setting_value('visiosoft.module.subscriptions::register_default_plan');

            if ($plan = $planRepository->find($default_plan)) {
                $subscriptions = $subscriptionRepository->getByAssign($this->user->id);

                if (count($subscriptions)) {

                    foreach ($subscriptions as $subscription)
                    {
                        if ($subscription->isActive())
                        {
                            break;
                        }
                    }

                } else {
                    $subscription = $subscriptionRepository->createNew($this->user->getId(), $plan, false);
                }
                event(new SubscriptionCreatedForActivatedUser($subscription));
            }
        }
    }
}
