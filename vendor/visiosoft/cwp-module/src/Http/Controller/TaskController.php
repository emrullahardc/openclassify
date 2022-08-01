<?php namespace Visiosoft\CwpModule\Http\Controller;

use Anomaly\Streams\Platform\Http\Controller\ResourceController;
use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\CwpModule\Task\Table\TaskTableBuilder;

class TaskController extends ResourceController
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
            dd($this->repository->newRequest($this->request->function, $this->request->params));
        }
    }
}
