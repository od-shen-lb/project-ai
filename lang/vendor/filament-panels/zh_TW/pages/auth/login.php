<?php

return [

    'title'         => '登入',

    'heading'       => '登入帳號',

    'actions'       => [

        'request_password_reset' => [
            'label' => '忘記密碼',
        ],

    ],

    'form'          => [

        'email'    => [
            'label' => 'Email',
        ],

        'password' => [
            'label' => '密碼',
        ],

        'remember' => [
            'label' => '記住我',
        ],

        'actions'  => [

            'authenticate' => [
                'label' => '登入',
            ],

        ],

    ],

    'messages'      => [

        'failed' => '帳號或密碼錯誤，請重新輸入。',

    ],

    'notifications' => [

        'throttled' => [
            'title' => '嘗試登入次數過多。請在 :seconds 秒後重試。',
        ],

    ],

];
