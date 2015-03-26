<?php
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=avtosm_crm',
            'username' => 'root',
            'password' => 'toor',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];