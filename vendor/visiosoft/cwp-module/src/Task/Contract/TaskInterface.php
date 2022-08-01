<?php namespace Visiosoft\CwpModule\Task\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

interface TaskInterface extends EntryInterface
{
    public function hasExistsInDBError();

    public function hasExistsInServerError();

    public function hasUserDoesntExistError();

    public function hasError($error);

    public function getRespone();
}
