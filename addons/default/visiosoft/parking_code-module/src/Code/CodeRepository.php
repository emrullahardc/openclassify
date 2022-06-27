<?php namespace Visiosoft\ParkingCodeModule\Code;

use Visiosoft\ParkingCodeModule\Code\Contract\CodeRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class CodeRepository extends EntryRepository implements CodeRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var CodeModel
     */
    protected $model;

    /**
     * Create a new CodeRepository instance.
     *
     * @param CodeModel $model
     */
    public function __construct(CodeModel $model)
    {
        $this->model = $model;
    }
}
