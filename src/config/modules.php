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

    'work_subject' => [
        'class' => 'app\modules\work_subject\Module',
    ],

    'directories' => [
        'class' => 'app\modules\directories\Module',
    ],

]);