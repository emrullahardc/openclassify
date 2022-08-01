<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleCwpCreateServerStream extends Migration
{

    /**
     * This migration creates the stream.
     * It should be deleted on rollback.
     *
     * @var bool
     */
    protected $delete = false;

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'server',
        'title_column' => 'server_ip',
        'translatable' => false,
        'versionable' => false,
        'trashable' => true,
        'searchable' => false,
        'sortable' => false,
    ];

    protected $fields = [
        'name' => 'anomaly.field_type.text',
        'node_name' => [
            'type' => 'anomaly.field_type.slug',
            'config' => [
                'slugify' => 'name',
                'type' => '_'
            ],
        ],
        'api_key' => 'anomaly.field_type.text',
        'api_url' => 'anomaly.field_type.text',
        'server_ip' => 'anomaly.field_type.text',
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'name' => [
            'required' => true,
        ],
        'node_name' => [
            'required' => true,
            'unique' => true,
        ],
        'api_key' => [
            'required' => true,
        ],
        'api_url' => [
            'required' => true,
        ],
        'server_ip' => [
            'required' => true,
        ],
    ];

}
