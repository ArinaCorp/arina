<?php

$params = require(__DIR__ . '/params.php');
$modules = require(__DIR__ . '/modules.php');

Yii::setAlias('@webroot', dirname(dirname(__DIR__)) . '/web');

return [
    'id' => 'console-app',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/runtime',
    'bootstrap' => ['log', 'core', 'queue'],
    'modules' => $modules,
    'params' => $params,
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
        'authManager' => [
            'class' => \dektrium\rbac\components\DbManager::class,
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'default',
            'mutex' => \yii\mutex\MysqlMutex::class,
        ],
        'i18n' => [
            'translations' => [
                '*' => ['class' => 'yii\i18n\PhpMessageSource'],
                'admin' => ['class' => \nullref\core\components\i18n\PhpMessageSource::class],
                'rbac' => ['class' => \nullref\core\components\i18n\PhpMessageSource::class],
                'user' => ['class' => \nullref\core\components\i18n\PhpMessageSource::class],
            ],
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => [
                'yii\queue\db\migrations',
            ],
        ],
    ],
];
