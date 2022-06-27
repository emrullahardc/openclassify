<?php namespace Visiosoft\ParkingCodeModule\Http\Controller\Admin;

use Visiosoft\ParkingCodeModule\Code\Form\CodeFormBuilder;
use Visiosoft\ParkingCodeModule\Code\Table\CodeTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class CodeController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param CodeTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(CodeTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param CodeFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(CodeFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param CodeFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(CodeFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
