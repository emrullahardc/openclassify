<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleSubscriptionsCreateLogStream extends Migration
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
        'slug' => 'log',
        'title_column' => 'type',
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
        'type',
        'value',
        'stream',
        'status',
        'entry'
    ];

}
