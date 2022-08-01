<?php
use Visiosoft\SubscriptionsModule\Plan\PlanModel;

return [
    'register_default_plan' => [
        'type' => 'anomaly.field_type.relationship',
        'config' => [
            'related' => PlanModel::class,
            'default_value' => 1,
        ],
    ],
    'create_limit_features' => [
        'type' => 'anomaly.field_type.checkboxes',
        'config' => [
            'handler' => \Visiosoft\SubscriptionsModule\Feature\Handler\CreateLimitOptions::class,
        ],
    ],
];
