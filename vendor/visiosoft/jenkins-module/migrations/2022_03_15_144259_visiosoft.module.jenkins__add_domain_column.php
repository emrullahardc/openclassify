<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleJenkinsAddDomainColumn extends Migration
{
    protected $stream = [
        'slug' => 'site',
    ];

    protected $fields = [
        'type_domain' => [
            'type' => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => false
            ],
        ],
    ];

    protected $assignments = [
        'type_domain',
    ];
}
