<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleJenkinsAddSubdomainId extends Migration
{
    protected $stream = [
        'slug' => 'site',
    ];

    protected $fields = [
        'site' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'related' => \Visiosoft\SiteModule\Site\SiteModel::class
            ],
        ],
    ];

    protected $assignments = [
        'site',
    ];
}
