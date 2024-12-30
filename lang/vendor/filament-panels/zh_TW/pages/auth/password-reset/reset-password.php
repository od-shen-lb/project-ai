<?php

return [

    'title'         => '設定密碼',

    'heading'       => '設定密碼',

    'form'          => [

        'email'                 => [
            'label' => 'Email',
        ],

        'password'              => [
            'label'                => '密碼（請填寫八碼英數字以上）',
            'validation_attribute' => '密碼',
        ],

        'password_confirmation' => [
            'label' => '確認密碼',
        ],

        'actions'               => [

            'reset' => [
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
