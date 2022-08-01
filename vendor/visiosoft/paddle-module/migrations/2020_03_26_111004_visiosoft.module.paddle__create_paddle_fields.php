<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModulePaddleCreatePaddleFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'paddle_response' => "visiosoft.field_type.json",
        'response_type' => "anomaly.field_type.text",
    ];

}
