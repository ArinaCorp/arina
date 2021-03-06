<?php

$params = require(__DIR__ . '/params.php');
$modules = require(__DIR__ . '/modules.php');

$config = [
    'id' => 'app',
    'name' => 'АСУ ХПК НУ "ЛП"',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/runtime',
    'bootstrap' => ['log', 'queue'],
    'language' => 'uk',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'nullref\admin\assets\AdminAsset' => [
                    'js' => [
                        'js/tools.js',
                        'js/scripts.js',
                    ],
                    'css' => [
                        'css/main.css',
                    ],
                    'depends' => [
                        'yii\web\YiiAsset',
                        'nullref\sbadmin\assets\SBAdminAsset',
                        'app\assets\NotifyAsset',
                    ]
                ],
            ],
        ],
        'excel' => [
            'class' => 'app\components\Excel',
        ],
        'formatter' => [
            'class' => 'app\components\Formatter',
            'timeZone' => 'Europe/Kiev',
        ],
        'request' => [
            'cookieValidationKey' => 'RiAveGUdUACvWZppHVevMJRGd5Rij8uh',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => YII_MAIL_USE_FILE_TRANSPORT,
        ],
        'i18n' => [
            'translations' => [
                '*' => ['class' => 'yii\i18n\PhpMessageSource'],
                'admin' => ['class' => \nullref\core\components\i18n\PhpMessageSource::class],
                'rbac' => ['class' => \nullref\core\components\i18n\PhpMessageSource::class],
                'user' => ['class' => \nullref\core\components\i18n\PhpMessageSource::class],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'default',
            'mutex' => \yii\mutex\MysqlMutex::class,
        ],
        'calendar' => [
            'class' => \app\modules\plans\components\Calendar::class,
        ],
    ],
    'modules' => $modules,
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] =
        [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['*'],
            'enableDebugLogs' => true,
        ];
}

return $config;
