<?php namespace Visiosoft\SubscriptionsModule\Plan\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

interface PlanRepositoryInterface extends EntryRepositoryInterface
{
    public function findByPaddleId($paddle_id);
}
