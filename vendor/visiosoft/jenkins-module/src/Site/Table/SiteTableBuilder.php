<?php namespace Visiosoft\JenkinsModule\Site\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

class SiteTableBuilder extends TableBuilder
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
        'site'
    ];

    /**
     * The table columns.
     *
     * @var array|string
     */
    protected $columns = [
        'subdomain','create','suspend','update','delete','addon','addonName' => [
            'value' => '{entry.addonName}-{entry.addonType}',
        ],
    ];

    /**
     * The table buttons.
     *
     * @var array|string
     */
    protected $buttons = [
        'edit',
        'show_log' => [
            'text' => 'visiosoft.module.jenkins::button.show_log',
            'href' => 'admin/jenkins/show-log/{entry.id}',
            'icon' => 'fa fa-code',
            'type' => 'primary'
        ],
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
    protected $options = [
        'order_by' => [
            'id' => 'DESC'
        ],
    ];

    /**
     * The table assets.
     *
     * @var array
     */
    protected $assets = [];

}
