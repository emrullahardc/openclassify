<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleParkingCodeCreateParkingCodeFields extends Migration
{
    protected $fields = [
        'name' => 'anomaly.field_type.text',
        'slug' => [
            'type' => 'anomaly.field_type.slug',
            'config' => [
                'slugify' => 'name',
                'type' => '_'
            ],
        ],
        'code_type' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'related' => \Visiosoft\ParkingCodeModule\CodeType\CodeTypeModel::class
            ]
        ],
        'code_status' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'related' => \Visiosoft\ParkingCodeModule\CodeStatus\CodeStatusModel::class
            ]
        ],
        'code_string' => [
            'type' => 'anomaly.field_type.text'
        ],
        'name_3chr' => [
            'type' => 'anomaly.field_type.text'
        ],
        'name_4chr' => [
            'type' => 'anomaly.field_type.text'
        ],
        'user' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'related' => \Anomaly\UsersModule\User\UserModel::class,
                'mode' => 'lookup'
            ]
        ],
        'code' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'related' => \Visiosoft\ParkingCodeModule\Code\CodeModel::class,
                'mode' => 'lookup'
            ]
        ],
        'percent' => 'anomaly.field_type.integer'
    ];
}
