<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleSubscriptionsAddPaddleSubscriptionsId extends Migration
{

    /**
     * @var bool
     */
    protected $delete = false;


    /**
     * @var array
     */
    protected $stream = [
        'slug' => 'subscriptions',
    ];


    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'paddle_subscription_id' => [
            'type' => 'anomaly.field_type.integer',
        ],
    ];

    /**
     * @var array
     */
    protected $assignments = [
        'paddle_subscription_id',
    ];

}
