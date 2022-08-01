<?php namespace Visiosoft\SubscriptionsModule\Subscription\Table\Query;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class AssignFilterQuery
{

    public function handle(Builder $query, FilterInterface $filter)
    {
        $query->where('subscriptions_subscriptions.assign_id', $filter->getValue());
    }
}
