<?php namespace Visiosoft\SubscriptionsModule\Subscription;

use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class SubscriptionRepository extends EntryRepository implements SubscriptionRepositoryInterface
{
    protected $model;

    public function __construct(SubscriptionModel $model)
    {
        $this->model = $model;
    }

    public function getByAssign($user_id, $orderByDesc = 'id')
    {
        return $this->newQuery()
            ->where('assign_id', $user_id)
            ->orderByDesc($orderByDesc)
            ->get();
    }

    public function findActive($id)
    {
        if ($subscription = $this->find($id) and $subscription->isActive()) {
            return $subscription;
        }
        return null;
    }

    public function findByPaddleId($paddle_id)
    {
        return $this->findBy('paddle_subscription_id', $paddle_id);
    }

    public function getActiveSubscriptions()
    {
        return $this->newQuery()
            ->where('suspend_at', null)
            ->get();
    }

    public function getWithExpired($date, $operator = '=')
    {
        return $this->newQuery()
            ->where('expires_at', $operator, $date)
            ->get();
    }

    public function createNew($user_id, $plan, $enabled = true, $paddle_subscription_id = null)
    {
        return $this->create([
            'assign_id' => $user_id,
            'paddle_subscription_id' => $paddle_subscription_id,
            'plan' => $plan,
            'enabled' => $enabled
        ]);
    }
}
