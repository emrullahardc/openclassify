<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleSubscriptionsAddSummaryPlan extends Migration
{
    protected $stream = [
        'slug' => 'plan',
    ];

    protected $fields = [
        'summary' => 'anomaly.field_type.text',
    ];

    protected $assignments = [
        'summary' => [
            'translatable' => true,
        ],
        'description' => [
            'translatable' => true,
        ],
    ];
}
