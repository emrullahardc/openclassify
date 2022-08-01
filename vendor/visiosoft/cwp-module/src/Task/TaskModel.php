<?php namespace Visiosoft\CwpModule\Task;

use Visiosoft\CwpModule\Task\Contract\TaskInterface;
use Anomaly\Streams\Platform\Model\Cwp\CwpTaskEntryModel;

class TaskModel extends CwpTaskEntryModel implements TaskInterface
{
    public function hasExistsInDBError()
    {
        return $this->hasError('already exists in database');
    }

    public function hasExistsInServerError()
    {
        return $this->hasError('already exists on server');
    }

    public function hasUserDoesntExistError()
    {
        return $this->hasError('User does not exist');
    }

    public function hasError($error)
    {
        $response = $this->getRespone();

        if (empty($response)) {
            return false;
        }

        if (!empty($response['status'])) {
            if ($response['status'] !== 'Error') {
                return false;
            }
        }

        if (strpos($response['msj'], $error) !== false) {
            return true;
        }

        return false;
    }

    public function getRespone()
    {
        return (array) json_decode($this->response);
    }
}
