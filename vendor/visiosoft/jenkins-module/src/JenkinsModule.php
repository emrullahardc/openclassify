<?php namespace Visiosoft\JenkinsModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

class JenkinsModule extends Module
{

    /**
     * The navigation display flag.
     *
     * @var bool
     */
    protected $navigation = false;

    /**
     * The addon icon.
     *
     * @var string
     */
    protected $icon = 'fa fa-puzzle-piece';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'site' => [
        ],
    ];

}
