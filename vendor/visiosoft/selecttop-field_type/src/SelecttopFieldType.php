<?php namespace Visiosoft\SelecttopFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

class SelecttopFieldType extends FieldType
{

    protected $inputView = null;
    
    protected $config = [
        'selector' => ':',
        'handler'  => 'options',
        'mode'     => 'dropdown',
    ];
}
