<?php namespace Visiosoft\SubscriptionsModule\Http\Controller\Admin;

use Visiosoft\SubscriptionsModule\Feature\Form\FeatureFormBuilder;
use Visiosoft\SubscriptionsModule\Feature\Table\FeatureTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class FeaturesController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param FeatureTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(FeatureTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param FeatureFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(FeatureFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param FeatureFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(FeatureFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
