<?php

return [

    'title'         => '設定密碼',

    'heading'       => '設定密碼',

    'actions'       => [

        'login' => [
            'label' => '回到登入',
        ],

    ],

    'form'          => [

        'email'   => [
            'label' => 'Email',
        ],

        'actions' => [

            'request' => [
                'label' => '送出',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => '嘗試次數過多',
            'body'  => '嘗試次數過多。請在 :seconds 秒後重試。',
        ],

    ],

];
