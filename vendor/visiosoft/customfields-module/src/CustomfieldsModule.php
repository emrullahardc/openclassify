<?php namespace Visiosoft\CustomfieldsModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

class CustomfieldsModule extends Module
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
    protected $icon = 'fa fa-braille';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'custom_fields' => [
            'buttons' => [
                'new_custom_field',
                'assets_clear' => [
                    'type' => 'warning',
                    'icon' => 'fa fa-refresh',
                    'href' => '/admin/assets/clear',
                ]
            ],
        ],
        'cfvalue' => [
            'buttons' => [
                'new_cfvalue' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'href'        => 'admin/customfields/cfvalue/choose',
                ],
            ],
        ],
    ];

}
