<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleJenkinsCreateJenkinsFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'subdomain' => 'anomaly.field_type.text',
        'domain' => 'anomaly.field_type.text',
        'email' => 'anomaly.field_type.text',
        'username' => 'anomaly.field_type.text',
        'password' => 'anomaly.field_type.text',
        'create' => [
            'type' => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => false,
            ],
        ],
        'suspend' => [
            'type' => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => false,
            ],
        ],
        'update' => [
            'type' => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => false,
            ],
        ],
        'delete' => [
            'type' => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => false,
            ],
        ],
        'addon' => [
            'type' => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => false,
            ],
        ],
        'queueId' => 'anomaly.field_type.text',
        'addonName' => 'anomaly.field_type.text',
        'addonType' => 'anomaly.field_type.text',
        'type' => [
            'type' => 'anomaly.field_type.text',
            'config' => [
                'default_value' => "autoclassified",
            ],
        ],
    ];

}
