<?php

return array_merge(require(__DIR__ . '/installed_modules.php'), [
    'core' => [
        'class' => 'nullref\core\Module'
    ],

    'admin' => [
        'class' => 'app\modules\admin\Module',
        'adminComponent' => 'user',
        'components' => [
            'menuBuilder' => [
                'class' => 'app\components\MenuBuilder',
            ],
        ],
        'accessControl' => [
            'class' => app\modules\rbac\filters\AccessControl::class,
        ],
    ],

    'students' => [
        'class' => 'app\modules\students\Module',
    ],

    'directories' => [
        'class' => 'app\modules\directories\Module',
    ],

    'employee' => [
        'class' => 'app\modules\employee\Module',
    ],
    'geo' => [
        'class' => 'app\modules\geo\Module',
    ],
    'plans' => [
        'class' => 'app\modules\plans\Module',
    ],
    'journal' => [
        'class' => 'app\modules\journal\Module',
    ],
    'accounting' => [
        'class' => 'app\modules\accounting\Accounting',
    ],
    'rbac' => [
        'class' => app\modules\rbac\Module::class,
    ],
    'load' => [
        'class' => app\modules\load\Module::class,
    ],
    'user' => [
        'class' => app\modules\user\Module::class,
        'admins' => ['admin'],
        'modelMap' => [
            'User' => 'app\modules\user\models\User',
        ],
    ],
]);