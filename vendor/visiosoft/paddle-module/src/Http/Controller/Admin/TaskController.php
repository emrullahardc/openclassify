<?php namespace Visiosoft\PaddleModule\Http\Controller\Admin;

use Visiosoft\PaddleModule\Task\Form\TaskFormBuilder;
use Visiosoft\PaddleModule\Task\Table\TaskTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class TaskController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param TaskTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(TaskTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param TaskFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(TaskFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param TaskFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(TaskFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
