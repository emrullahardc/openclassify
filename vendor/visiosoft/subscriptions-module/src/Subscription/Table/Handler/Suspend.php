<?php namespace Visiosoft\SubscriptionsModule\Subscription\Table\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Event\SuspendedSubscription;


class Suspend extends ActionHandler
{
    public function handle(array $selected, SubscriptionRepositoryInterface $repository)
    {
        foreach ($selected as $item) {
            if ($subscription = $repository->find($item)) {
                $subscription->suspend();
                event(new SuspendedSubscription($subscription));
            }
        }
        $this->messages->success(trans('visiosoft.module.subscriptions::message.suspended'));
    }
}