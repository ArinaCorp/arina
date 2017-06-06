<?php

return array_merge(require(__DIR__ . '/installed_modules.php'), [
    'core' => [
        'class' => 'nullref\core\Module'
    ],

    'admin' => [
        'class' => 'nullref\admin\Module'
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
    'load' => [
        'class' => 'app\modules\load\Module',
    ],
    'journal' => [
        'class' => 'app\modules\journal\Module',
    ],
    'accounting' => [
        'class' => 'app\modules\accounting\Accounting',
    ],
]);