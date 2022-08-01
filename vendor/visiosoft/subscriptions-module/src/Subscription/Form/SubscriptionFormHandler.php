<?php namespace Visiosoft\SubscriptionsModule\Subscription\Form;

use Visiosoft\SubscriptionsModule\Subscription\Event\CreatedSubscription;

class SubscriptionFormHandler
{
    public function handle(SubscriptionFormBuilder $builder)
    {
        if (!$builder->canSave()) {
            return;
        }

        $builder->saveForm();

        $subscription = $builder->getFormEntry();

        if (request()->action == "save_create" or request()->action == "save") {
            event(new CreatedSubscription($subscription));
        }
    }
}
