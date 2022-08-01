<?php namespace Visiosoft\SubscriptionsModule\Subscription\Listener\paddle;

use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Visiosoft\PaddleModule\Event\SubscriptionPaymentSucceededPaddle;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Event\UpgradeSubscription;
use Visiosoft\SubscriptionsModule\Subscription\Event\webhook\SubscriptionCreatedForWebhook;
use Visiosoft\SubscriptionsModule\Subscription\Event\webhook\SubscriptionRenewedForWebhook;

class SubscriptionPaymentSucceeded
{
    private $plan;
    private $user;
    private $subscription;

    public function __construct(
        PlanRepositoryInterface $plan,
        UserRepositoryInterface $user,
        SubscriptionRepositoryInterface $subscription)
    {
        $this->plan = $plan;
        $this->user = $user;
        $this->subscription = $subscription;
    }

    public function handle(SubscriptionPaymentSucceededPaddle $event)
    {
        $subscription_created = $event->getResponse();

        $payment = ($subscription_created['status'] === "trialing") ? false : true;

        if (!$plan = $this->plan->findByPaddleId($subscription_created['subscription_plan_id'])) {
            $default_plan = setting_value('visiosoft.module.subscriptions::register_default_plan');

            $plan = $this->plan->find($default_plan);
        }

        if ($user = $this->user->findByEmail($subscription_created['email'])) {

            if (!is_null($subscription = $this->subscription->findByPaddleId($subscription_created['subscription_id']))) {

                $subscription->renew();

                event(new SubscriptionRenewedForWebhook($subscription, $subscription_created));
            } else {
                $subscription = $this->subscription->createNew($user->getId(), $plan, $payment, $subscription_created['subscription_id']);

                $passthrough = json_decode($subscription_created['passthrough'], true);

                //Is Old Subscription ID parameter
                if (isset($passthrough['subscription_id'])) {
                    //Check Old Subscription
                    if ($old_subscription = $this->subscription->find($passthrough['subscription_id'])) {
                        //Upgrade Event For Sites (moves old sites to new subscription)
                        event(new UpgradeSubscription($old_subscription, $subscription));

                        //Delete old Subscription
                        $old_subscription->delete();
                    }
                }

                event(new SubscriptionCreatedForWebhook($subscription, $subscription_created));
            }
        }

    }
}
