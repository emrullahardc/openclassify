<?php namespace Visiosoft\SubscriptionsModule\Subscription\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

interface SubscriptionRepositoryInterface extends EntryRepositoryInterface
{

    public function getByAssign($user_id, $orderByDesc = 'id');

    public function findActive($id);

    public function findByPaddleId($paddle_id);

    public function getActiveSubscriptions();

    public function getWithExpired($date, $operator = '=');

    public function createNew($user_id, $plan, $enabled = true, $paddle_subscription_id = null);
}
