<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleCwpCreateCwpFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'function' => 'anomaly.field_type.text',
        'request' => "visiosoft.field_type.json",
        'response' => "visiosoft.field_type.json",
        'status' => [
            'type' => "anomaly.field_type.boolean",
            'config' => [
                'default_value' => false,
            ]
        ],
    ];

}
