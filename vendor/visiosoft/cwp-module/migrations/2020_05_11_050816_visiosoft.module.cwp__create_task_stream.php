<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleCwpCreateTaskStream extends Migration
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
        'title_column' => 'id',
        'translatable' => false,
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
        'function',
        'request',
        'response',
        'status'
    ];

}
