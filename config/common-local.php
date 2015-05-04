<?php
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=178.62.250.164;dbname=avtosm_avtosm_crm',
            'username' => 'avtosm_avtosm',
            'password' => 'V4s3tmPBI9',
//            'dsn' => 'mysql:host=localhost;dbname=avtosm_avtosm_crm',
//            'username' => 'root',
//            'password' => 'root',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];