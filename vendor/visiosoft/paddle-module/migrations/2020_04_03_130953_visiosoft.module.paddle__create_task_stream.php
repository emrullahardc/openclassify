<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModulePaddleCreateTaskStream extends Migration
{

    /**
     * This migration creates the stream.
     * It should be deleted on rollback.
     *
     * @var bool
     */
    protected $delete = true;

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'task',
        'title_column' => 'response_type',
        'translatable' => true,
        'versionable' => false,
        'trashable' => true,
        'searchable' => false,
        'sortable' => false,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'response_type' => [
            'required' => true,
        ],
        'paddle_response' => [
            'required' => true,
        ],
    ];

}
