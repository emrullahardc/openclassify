<?php namespace Visiosoft\SubscriptionsModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

class SubscriptionsModule extends Module
{

    /**
     * The navigation display flag.
     *
     * @var bool
     */
    protected $navigation = true;

    /**
     * The addon icon.
     *
     * @var string
     */
    protected $icon = 'refresh';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'subscriptions' => [
            'buttons' => [
                'new_subscription',
            ],
        ],
        'plan' => [
            'buttons' => [
                'new_plan',
            ],
        ],
        'features' => [
            'buttons' => [
                'new_feature',
            ],
        ],
        'settings' => [
            'href' => 'admin/settings/modules/visiosoft.module.subscriptions',
            'title' => 'visiosoft.module.subscriptions::section.settings.title'
        ],
        'log' => [
            'buttons' => [
                'new_log',
            ],
        ],
    ];

}
