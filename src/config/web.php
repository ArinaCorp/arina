<?php

$params = require(__DIR__ . '/params.php');
$modules = require(__DIR__ . '/modules.php');

$config = [
    'id' => 'app',
    'name' => 'АСУ ХПК НУ "ЛП"',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/runtime',
    'bootstrap' => ['log'],
    'language' => 'uk',
    'components' => [
        'assetManager' => [
            'bundles' => [
                'nullref\admin\assets\AdminAsset' => [
                    'js' => [
                        'js/tools.js',
                        'js/admin/scripts.js',
                    ],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'excel' => [
            'class' => 'app\components\Excel',
        ],
        'formatter' => [
            'class' => 'app\components\Formatter',
        ],
        'request' => [
            'cookieValidationKey' => 'RiAveGUdUACvWZppHVevMJRGd5Rij8uh',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'nullref\admin\components\User',
            'identityClass' => 'nullref\admin\models\Admin',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => YII_ENV_DEV,
        ],
        'i18n' => [
            'translations' => [
                '*' => ['class' => 'yii\i18n\PhpMessageSource'],
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
        ],
        'db' => require(__DIR__ . '/db.php'),
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
        ];
}

return $config;
