<?php

return [
    'enabled'   => env('API_LOGGER_ENABLED', false),
    'formatter' => LeadBest\ApiLogger\Formatter\StackDriverFormatter::class,
    'request'   => [
        'log_headers'   => [],
        'except_inputs' => [],
    ],
    'response'  => [
        'enabled'       => env('API_LOGGER_LOG_RESPONSE', false),
        'except_fields' => [],
    ],
];
