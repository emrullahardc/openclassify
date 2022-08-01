<?php namespace Visiosoft\RadioFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

class RadioFieldType extends FieldType
{

    protected $inputView = null;
    
    protected $config = [
        'selector' => ':',
        'handler'  => 'options',
        'mode'     => 'radio',
    ];

}
