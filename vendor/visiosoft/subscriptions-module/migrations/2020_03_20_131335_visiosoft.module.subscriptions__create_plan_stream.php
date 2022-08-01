<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleSubscriptionsCreatePlanStream extends Migration
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
        'slug' => 'plan',
        'title_column' => 'name',
        'translatable' => true,
        'versionable' => false,
        'trashable' => true,
        'searchable' => false,
        'sortable' => true,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'name' => [
            'translatable' => true,
            'required' => true,
        ],
        'slug' => [
            'unique' => true,
            'required' => true,
        ],
        'feature',
        'price' => [
            'required' => true,
        ],
        'currency' => [
            'required' => true,
        ],
        'trial_interval',
        'trial_period',
        'interval',
        'interval_period',
        'paddle_plan_id'
    ];

}
