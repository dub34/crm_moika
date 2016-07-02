<?php

return [
    'components' => [
        'db' => [
//            'dsn' => 'mysql:host=178.62.250.164;dbname=avtosm_avtosm_crm',
//            'username' => 'avtosm_avtosm',
//            'password' => 'V4s3tmPBI9',
            'dsn' => 'mysql:host=localhost;dbname=avtosm_avtosm_crm1',
            'username' => 'root',
            'password' => '1111',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => '@app/runtime/logs/console-error.log'
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logFile' => '@app/runtime/logs/console-warning.log'
                ],
            ],
        ],
    ],
];
