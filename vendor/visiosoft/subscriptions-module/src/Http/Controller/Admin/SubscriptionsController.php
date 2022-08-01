<?php namespace Visiosoft\SubscriptionsModule\Http\Controller\Admin;

use Visiosoft\SubscriptionsModule\Subscription\Form\SubscriptionFormBuilder;
use Visiosoft\SubscriptionsModule\Subscription\Table\SubscriptionTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class SubscriptionsController extends AdminController
{

    public function index(SubscriptionTableBuilder $table)
    {
        return $table->render();
    }

    public function create(SubscriptionFormBuilder $form)
    {
        return $form->render();
    }

    public function edit(SubscriptionFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
