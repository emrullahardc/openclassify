<?php namespace Visiosoft\SubscriptionsModule\Subscription\Table\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Event\UnSuspendedSubscription;


class UnSuspend extends ActionHandler
{
    public function handle(array $selected, SubscriptionRepositoryInterface $repository)
    {
        foreach ($selected as $item) {
            if ($subscription = $repository->find($item)) {

                $subscription->enabled();

                event(new UnSuspendedSubscription($subscription));
            }
        }
        $this->messages->success(trans('visiosoft.module.subscriptions::message.unsuspended'));
    }
}