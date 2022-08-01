<?php namespace Visiosoft\SubscriptionsModule\Subscription\Listener\site;

use Anomaly\Streams\Platform\Message\MessageBag;
use Visiosoft\SiteModule\Site\Event\subscriptions\CreateSubscriptionForChangeSitePlan;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;

class NewSubscriptionForChangeSitePlan
{
    private $subscription;
    private $planRepository;
    private $message;

    public function __construct(SubscriptionRepositoryInterface $subscription, PlanRepositoryInterface $planRepository, MessageBag $message)
    {
        $this->subscription = $subscription;
        $this->planRepository = $planRepository;
        $this->message = $message;
    }

    public function handle(CreateSubscriptionForChangeSitePlan $event)
    {
        $plan = $this->planRepository->find($event->getPlanId());

        $user = $event->getUser();

        $subscription = $this->subscription->createNew($user->getId(), $plan, true);

        $entry = $event->getEntry();

        $old_subscription = $entry->subscription;

        try {
            $entry->setAttribute('subscription_id', $subscription->getId());
            $entry->save();

            if ($old_subscription) {
                $old_subscription->suspend();
            }

            $this->message->success(trans('visiosoft.module.subscriptions::message.updated_subscription'));

        } catch (\Exception $exception) {
            $this->message->error([$exception->getMessage()]);
        }
    }
}
