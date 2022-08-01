<?php namespace Visiosoft\SubscriptionsModule\Plan\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

class PlanTableBuilder extends TableBuilder
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
    protected $filters = [];

    /**
     * The table columns.
     *
     * @var array|string
     */
    protected $columns = [
        'name',
        'trial' => [
            'value' => '{% if entry.trial_period %}{entry.trial_interval} {{trans("visiosoft.module.subscriptions::field."~entry.trial_period~".name")}}{% else %}-{% endif %}'
        ],
        'interval' => [
            'value' => '{% if entry.interval_period %}{entry.interval} {{trans("visiosoft.module.subscriptions::field."~entry.interval_period~".name")}}{% else %}-{% endif %}'
        ],
        'price' => [
            'value' => '{entry.price} {entry.currency}'
        ]
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
        'delete'
    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The table assets.
     *
     * @var array
     */
    protected $assets = [];

}
