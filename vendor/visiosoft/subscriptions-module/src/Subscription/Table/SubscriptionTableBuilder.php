<?php namespace Visiosoft\SubscriptionsModule\Subscription\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Visiosoft\SubscriptionsModule\Subscription\Table\Handler\Delete;
use Visiosoft\SubscriptionsModule\Subscription\Table\Handler\Renew;
use Visiosoft\SubscriptionsModule\Subscription\Table\Handler\Suspend;
use Visiosoft\SubscriptionsModule\Subscription\Table\Handler\UnSuspend;
use Visiosoft\SubscriptionsModule\Subscription\Table\Query\AssignFilterQuery;

class SubscriptionTableBuilder extends TableBuilder
{

    /**
     * The table views.
     *
     * @var array|string
     */
    protected $views = [];

    /**
     * The table filters.
     *
     * @var array|string
     */
    protected $filters = [
        'trial_expires_at','expires_at','plan','assign' => [
                    'exact' => true,
                    'filter' => 'select',
                    'query' => AssignFilterQuery::class,
                ],
    ];

    /**
     * The table buttons.
     *
     * @var array|string
     */
    protected $buttons = [
        'edit'
    ];

    /**
     * The table actions.
     *
     * @var array|string
     */
    protected $actions = [
        'delete' => [
            'handler' => Delete::class,
        ],
        'suspend' => [
            'handler' => Suspend::class,
            'icon' => 'fa fa-eye'
        ],
        'unsuspend' => [
            'handler' => UnSuspend::class,
            'icon' => 'fa fa-eye-slash',
        ],
        'renew' => [
            'handler' => Renew::class,
            'icon' => 'fa fa-refresh',
            'type' => 'success'
        ],

    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [
        'order_by' => [
            'id' => 'DESC',
        ]
    ];

    /**
     * The table assets.
     *
     * @var array
     */
    protected $assets = [
        'scripts.js' => [
            'visiosoft.module.subscriptions::js/admin/filter-assign.js',
        ],
        'styles.css' => [
            'visiosoft.module.subscriptions::css/admin/filter-assign.css',
        ],
    ];

}
