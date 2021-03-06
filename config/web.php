<?php

$config = [
    'id' => 'app',
    'defaultRoute' => 'main/default/index',
    'components' => [
        'user' => [
            'identityClass' => 'app\modules\employee\models\EmployeeIdentity',
            'enableAutoLogin' => true,
            'loginUrl' => ['employee/default/login'],
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
            'errorView'=>'app\themes\adminlte\views\error'
        ],
        'request' => [
            'cookieValidationKey' => '',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
    ],
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1']
    ];
}

return $config;
