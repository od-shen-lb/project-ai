<?php

return [
    'bootstrap_file' => null,
    'base_domain'    => env('ROUTER_BASE_DOMAIN', 'localhost'),
    'doc_generate'   => storage_path('api-docs'),
    'annotations'    => [
        [
            'module_lookup'  => app_path('Http/Controllers'),
            'module_include' => [
                app_path('Http/Requests'),
                app_path('Http/Resources'),
            ],
            'common_include' => [
                app_path('Enums'),
            ],
        ],
    ],
];
