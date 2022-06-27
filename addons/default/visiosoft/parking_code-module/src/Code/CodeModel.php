<?php namespace Visiosoft\ParkingCodeModule\Code;

use Visiosoft\ParkingCodeModule\Code\Contract\CodeInterface;
use Anomaly\Streams\Platform\Model\ParkingCode\ParkingCodeCodeEntryModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CodeModel extends ParkingCodeCodeEntryModel implements CodeInterface
{
    use HasFactory;

    /**
     * @return CodeFactory
     */
    protected static function newFactory()
    {
        return CodeFactory::new();
    }
}
