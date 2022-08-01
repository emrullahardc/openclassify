<?php namespace Visiosoft\SubscriptionsModule\Log;

use Visiosoft\SubscriptionsModule\Log\Contract\LogRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class LogRepository extends EntryRepository implements LogRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var LogModel
     */
    protected $model;

    /**
     * Create a new LogRepository instance.
     *
     * @param LogModel $model
     */
    public function __construct(LogModel $model)
    {
        $this->model = $model;
    }

    public function getLogForParams($params)
    {
        $query = $this->newQuery();

        foreach ($params as $column => $value) {
            $query = $query->where($column, $value);
        }

        return $query->get();
    }

    public function getFirstRemainingLog($subscription_id, $remaining)
    {
        $params = [
            'stream' => 'subscriptions',
            'status' => true,
            'type' => 'remaining',
            'entry_id' => $subscription_id,
            'value' => $remaining
        ];

        if(count($log = $this->getLogForParams($params)))
        {
            return $log->first();
        }

        return null;
    }

    public function getFirstSuspendLog($subscription_id)
    {
        $params = [
            'stream' => 'subscriptions',
            'status' => true,
            'type' => 'suspend',
            'entry_id' => $subscription_id
        ];

        if(count($log = $this->getLogForParams($params)))
        {
            return $log->first();
        }

        return null;
    }

    public function createRemainingLog($subscription, $remaining)
    {
        return $this->create([
            'type' => 'remaining',
            'value' => $remaining,
            'stream' => 'subscriptions',
            'status' => true,
            'entry' => $subscription
        ]);
    }

    public function createSuspendLog($subscription)
    {
        return $this->create([
            'type' => 'suspend',
            'stream' => 'subscriptions',
            'status' => true,
            'entry' => $subscription
        ]);
    }
}
