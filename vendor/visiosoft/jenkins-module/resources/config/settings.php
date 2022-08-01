<?php

return [
    'username' => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => 'auto',
        ],
    ],
    'token' => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => '11e12c4305458f4414ef1a54ae6465822f',
        ],
    ],
    'url' => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => 'jenkins.visiosoft.com.tr/job/autoclassified%20CWP/buildWithParameters',
        ],
    ],
    'control_url' => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => 'jenkins.visiosoft.com.tr/job/autoclassified%20CWP/api/xml?tree=builds[id,number,result,queueId]',
        ],
    ],
    'token_parameter' => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => 'openClassifiedCreateHash',
        ],
    ],
    'subsite-token' => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => 'b321901a62d2377e817f3202d5264ade1de0cd74b807d71aa0a933f9a4df9b0e',
        ],
    ],
];
