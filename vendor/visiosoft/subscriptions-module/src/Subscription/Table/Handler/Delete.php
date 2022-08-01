<?php namespace Visiosoft\SubscriptionsModule\Subscription\Table\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Event\DeletedSubscription;


class Delete extends ActionHandler
{
    public function handle(array $selected, SubscriptionRepositoryInterface $repository)
    {
        foreach ($selected as $item) {
            $subscription = $repository->find($item);

            $subscription->delete();

            event(new DeletedSubscription($subscription));
        }
        $this->messages->success(trans('streams::::message.delete_success',['count' => count($selected)]));
    }
}