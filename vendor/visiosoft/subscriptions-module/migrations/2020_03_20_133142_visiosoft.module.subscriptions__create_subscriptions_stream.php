<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleSubscriptionsCreateSubscriptionsStream extends Migration
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
        'slug' => 'subscriptions',
        'title_column' => 'description',
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
        'assign' => [
            'required' => true,
        ],
        'plan' => [
            'required' => true,
        ],
        'trial_expires_at',
        'expires_at' => [
            'required' => true,
        ],
        'suspend_at',
        'enabled',
        'description' => [
            'translatable' => true,
        ],
        'entry',
    ];

}
