<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
                require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => 'CW-CRM',
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'language' => 'ru-BE',
    'sourceLanguage' => 'ru-RU',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'formatter' => [
            'locale' => 'be_BY',
            'currencyCode' => '',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
//            'useFileTransport' => false,
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.gmail.com',
//                'username' => '',
//                'password' => '',
//                'port' => '587',
//                'encryption' => 'tls',
//          ],
        ],
        'response' => [
            'formatters' => [
                'pdf' => [
                    'class' => 'robregonm\pdf\PdfResponseFormatter',
                    'mode' => '', // Optional
                    'format' => 'A4', // Optional but recommended. http://mpdf1.com/manual/index.php?tid=184
                    'defaultFontSize' => 0, // Optional
                    'defaultFont' => '', // Optional
                    'marginLeft' => 5, // Optional
                    'marginRight' => 5, // Optional
                    'marginTop' => 5, // Optional
                    'marginBottom' => 5, // Optional
                    'marginHeader' => 0, // Optional
                    'marginFooter' => 0, // Optional
//                    'orientation' => 'Landscape', // optional. This value will be ignored if format is a string value.
                    'options' => [
//                    'ignore_invalid_utf8' => true,  
//                    'allow_charset_conversion' => false,
                        // mPDF Variables
                        'fontdata' => [
                        'dejavusanscondensed' =>
                            array(
                                'B' => 'DejaVuSansCondensed-Bold.ttf',
                                'BI' => 'DejaVuSansCondensed-BoldOblique.ttf',
                                'I' => 'DejaVuSansCondensed-Oblique.ttf',
                                'R' => 'DejaVuSansCondensed.ttf',
                            ),
                        'dejavuserifcondensed' =>
                            array(
                                'B' => 'DejaVuSerifCondensed-Bold.ttf',
                                'BI' => 'DejaVuSerifCondensed-BoldItali.ttf',
                                'I' => 'DejaVuSerifCondensed-Italic.ttf',
                                'R' => 'DejaVuSerifCondensed.ttf',
                            ),
                        ]
                    ]
                ],
            ]
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'contract',
                'contact' => 'contact/default/index',
                '<_a:(about|error)>' => 'main/default/<_a>',
                '<_a:(login|logout)>' => 'employee/default/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
                '<_m:[\w\-]+>' => '<_m>/default/index',
                '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
            ],
        ],
        'view' => [
//            'class'=>'app\components\myview',
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/adminlte',
                    '@app/modules' => '@app/themes/adminlte/modules',
                ],
            ],
        ],
        'settings' => [
            'class' => 'pheme\settings\components\Settings'
        ],
       
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'log' => [
            'class' => 'yii\log\Dispatcher',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource'
                ],
            ],
        ],
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
        'employee' => [
            'class' => 'app\modules\employee\Module',
        ],
        'office' => [
            'class' => 'app\modules\office\Module',
        ],
        'client' => [
            'class' => 'app\modules\client\Module',
        ],
        'service' => [
            'class' => 'app\modules\service\Module',
        ],
        'contract' => [
            'class' => 'app\modules\contract\Module',
        ],
        'payment' => [
            'class' => 'app\modules\payment\Module',
        ],
        'ticket' => [
            'class' => 'app\modules\ticket\Module',
        ],
        'settings' => [
            'class' => 'pheme\settings\Module',
        ],
    ],
    'params' => $params,
];
