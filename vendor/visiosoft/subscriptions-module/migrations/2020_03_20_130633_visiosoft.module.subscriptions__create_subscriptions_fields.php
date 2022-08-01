<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\UsersModule\User\UserModel;
use Visiosoft\SubscriptionsModule\Feature\FeatureModel;
use Visiosoft\SubscriptionsModule\Plan\PlanModel;

class VisiosoftModuleSubscriptionsCreateSubscriptionsFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'name' => 'anomaly.field_type.text',
        'slug' => [
            'type' => 'anomaly.field_type.slug',
            'config' => [
                'slugify' => 'name',
                'type' => '_'
            ],
        ],
        'price' => [
            'type' => 'visiosoft.field_type.decimal',
            'config' => [
                'decimal' => 2,
                'separator' => '.',
                'point' => ','
            ]
        ],
        'currency' => [
            'type' => 'anomaly.field_type.select',
            'config' => [
                'handler' => 'currencies',
            ],
        ],
        'interval' => [
            'type' => 'anomaly.field_type.integer',
            'config' => [
                "min" => 1,
                "max" => 30,
            ],
        ],
        'interval_period' => [
            'type' => 'anomaly.field_type.select',
            'config' => [
                "options" => ["day" => "visiosoft.module.subscriptions::field.day.name", "week" => "Week", "month" => "Month"],
            ],
        ],
        'trial_interval' => [
            'type' => 'anomaly.field_type.integer',
            'config' => [
                "min" => 0,
                "max" => 30,
            ],
        ],
        'trial_period' => [
            'type' => 'anomaly.field_type.select',
            'config' => [
                'options' => [
                    'day' => 'visiosoft.module.subscriptions::field.day.name',
                    'week' => 'visiosoft.module.subscriptions::field.week.name',
                    'month' => 'visiosoft.module.subscriptions::field.month.name'
                ],
            ],
        ],
        'assign' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'mode' => 'lookup',
                'related' => UserModel::class,
            ],
        ],
        'plan' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'mode' => 'lookup',
                'related' => PlanModel::class,
            ],
        ],
        'feature' => [
            'type' => 'anomaly.field_type.multiple',
            'config' => [
                'mode' => 'tags',
                'related' => FeatureModel::class,
            ],
        ],
        'start_at' => 'anomaly.field_type.datetime',
        'expires_at' => 'anomaly.field_type.datetime',
        'trial_expires_at' => 'anomaly.field_type.datetime',
        'suspend_at' => 'anomaly.field_type.datetime',
        'enabled' => [
            'type' => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => false,
            ],
        ],
        'value' => 'anomaly.field_type.text',
        'description' => 'anomaly.field_type.textarea',
        'entry' => 'anomaly.field_type.polymorphic',
        'paddle_plan_id' => 'anomaly.field_type.integer',

        'type' => 'anomaly.field_type.text',
        'stream' => 'anomaly.field_type.text',
        'status' => 'anomaly.field_type.text',

    ];

}
