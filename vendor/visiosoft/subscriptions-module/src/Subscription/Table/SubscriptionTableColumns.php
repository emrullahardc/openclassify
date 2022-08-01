<?php namespace Visiosoft\SubscriptionsModule\Subscription\Table;

use Anomaly\Streams\Platform\Entry\EntryModel;

class SubscriptionTableColumns
{
    public function handle(SubscriptionTableBuilder $builder)
    {
        $builder->setColumns([
            'assign',
            'plan',
            'trial_expires_at',
            'expires_at',
            'remaining_time' => [
                'value' => function (EntryModel $entry) {
                    $value = $entry->getRemaining();

                    if ($entry->getSuspend()) {
                        $value = trans('visiosoft.module.subscriptions::field.suspended');
                    }

                    if ($value < 1 or $entry->getSuspend()) {
                        $value =  "<span class='text-danger'>" . $value . "</span>";
                    }

                    return $value;
                }
            ],
        ]);
    }
}
