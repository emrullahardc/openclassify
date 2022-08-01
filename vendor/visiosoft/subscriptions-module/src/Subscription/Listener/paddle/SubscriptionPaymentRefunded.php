<?php namespace Visiosoft\SubscriptionsModule\Subscription\Listener\paddle;

use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Visiosoft\PaddleModule\Event\SubscriptionPaymentRefundedPaddle;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Event\webhook\SubscriptionSuspendForWebhook;

class SubscriptionPaymentRefunded
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

    public function handle(SubscriptionPaymentRefundedPaddle $event)
    {
        $subscription_created = $event->getResponse();

        //Plan ve Kullanıcı Kontrolü Yap
        if ($subscription = $this->subscription->findByPaddleId($subscription_created['subscription_id'])
            and $user = $this->user->findByEmail($subscription_created['email'])) {

            $subscription->suspend();

            event(new SubscriptionSuspendForWebhook($subscription,$subscription_created));
        }
    }
}
