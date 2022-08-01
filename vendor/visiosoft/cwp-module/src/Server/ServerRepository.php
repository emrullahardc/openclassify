<?php namespace Visiosoft\CwpModule\Server;

use Visiosoft\CwpModule\Server\Contract\ServerRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class ServerRepository extends EntryRepository implements ServerRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var ServerModel
     */
    protected $model;

    /**
     * Create a new ServerRepository instance.
     *
     * @param ServerModel $model
     */
    public function __construct(ServerModel $model)
    {
        $this->model = $model;
    }
}
