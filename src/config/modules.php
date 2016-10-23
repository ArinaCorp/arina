<?php

return array_merge(require(__DIR__ . '/installed_modules.php'), [
    'core' => ['class' => 'nullref\core\Module'],
    'admin' => ['class' => 'nullref\admin\Module'],
    'students' => [
        'class' => 'app\modules\students\Module',
    ],
    'directories' => [
        'class' => 'app\modules\directories\Module',
    ],
]);