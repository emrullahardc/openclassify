<?php namespace Visiosoft\CwpModule\Http\Controller\Admin;

use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\CwpModule\Task\Table\TaskTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class TaskController extends AdminController
{
    private $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function index(TaskTableBuilder $table)
    {
        return $table->render();
    }

    public function test()
    {
        if (isset($this->request->function) and isset($this->request->params)) {
            dd($this->request->all());
            dd($this->repository->newRequest($this->request->function, $this->request->params));
        }
    }
}
