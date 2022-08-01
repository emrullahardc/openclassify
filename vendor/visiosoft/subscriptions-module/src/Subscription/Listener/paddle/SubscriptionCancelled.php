<?php namespace Visiosoft\SubscriptionsModule\Subscription\Listener\paddle;

use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Visiosoft\PaddleModule\Event\SubscriptionCancelledPaddle;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Event\webhook\SubscriptionDeletedForWebhook;

class SubscriptionCancelled
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

    public function handle(SubscriptionCancelledPaddle $event)
    {
        $subscription_created = $event->getResponse();

        //Plan ve Kullanıcı Kontrolü Yap
        if ($subscription = $this->subscription->findByPaddleId($subscription_created['subscription_id'])) {

            $subscription->delete();

            event(new SubscriptionDeletedForWebhook($subscription, $subscription_created));
        }
    }
}
