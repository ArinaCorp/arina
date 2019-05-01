<?php

namespace app\modules\plans;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * plans module definition class
 */
class Module extends BaseModule implements IAdminModule
{

    public function behaviors()
    {
        return [
//            'as AccessBehavior' => [
//                'class' => \developeruz\db_rbac\behaviors\AccessBehavior::className(),
//            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\plans\controllers';
    public $modelsNamespace = 'app\modules\plans\models';

    /**
     * @inheritdoc
     */
    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('plans', 'Plans'),
            'icon' => 'folder',
            'items' => [
                [
                    'label' => Yii::t('plans', 'Study plans'),
                    'url' => ['/plans/study-plan/index'],
                    'icon' => 'th-list',
                    'roles' => ['head-of-department', 'head-of-cyclic-commission'],
                ],
                [
                    'label' => Yii::t('plans', 'Create study plan'),
                    'url' => ['/plans/study-plan/create'],
                    'icon' => 'plus',
                    'roles' => ['head-of-department', 'head-of-cyclic-commission'],
                ],
                [
                    'label' => Yii::t('plans', 'Work plans'),
                    'url' => ['/plans/work-plan/index'],
                    'icon' => 'th-list',
                    'roles' => ['head-of-department', 'head-of-cyclic-commission'],
                ],
                [
                    'label' => Yii::t('plans', 'Create work plan'),
                    'url' => ['/plans/work-plan/create'],
                    'icon' => 'plus',
                    'roles' => ['head-of-department', 'head-of-cyclic-commission'],
                ],
                [
                    'label' => Yii::t('plans', 'Student plans'),
                    'url' => ['/plans/student-plan/index'],
                    'icon' => 'th-list',
                    'roles' => ['head-of-department', 'head-of-cyclic-commission'],
                ]
            ],
            'roles' => ['head-of-department', 'head-of-cyclic-commission'],
        ];
    }
}
