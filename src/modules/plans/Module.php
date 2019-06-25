<?php

namespace app\modules\plans;

use app\modules\user\models\User;
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
//                'class' => \developeruz\db_rbac\behaviors\AccessBehavior::class,
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
                    'roles' => [User::ROLE_HEAD_OF_DEP, User::ROLE_HEAD_OF_CYC_COM, User::ROLE_TEACHER],
                ],
                [
                    'label' => Yii::t('plans', 'Create study plan'),
                    'url' => ['/plans/study-plan/create'],
                    'icon' => 'plus',
                    'roles' => [User::ROLE_HEAD_OF_DEP, User::ROLE_HEAD_OF_CYC_COM],
                ],
                [
                    'label' => Yii::t('plans', 'Work plans'),
                    'url' => ['/plans/work-plan/index'],
                    'icon' => 'th-list',
                    'roles' => [User::ROLE_HEAD_OF_DEP, User::ROLE_HEAD_OF_CYC_COM, User::ROLE_TEACHER],
                ],
                [
                    'label' => Yii::t('plans', 'Create work plan'),
                    'url' => ['/plans/work-plan/create'],
                    'icon' => 'plus',
                    'roles' => [User::ROLE_HEAD_OF_DEP, User::ROLE_HEAD_OF_CYC_COM],
                ],
                [
                    'label' => Yii::t('plans', 'Student plans'),
                    'url' => ['/plans/student-plan/index'],
                    'icon' => 'th-list',
                    'roles' => [User::ROLE_HEAD_OF_DEP, User::ROLE_HEAD_OF_CYC_COM, User::ROLE_STUDENT],
                ]
            ],
            'roles' => [User::ROLE_HEAD_OF_DEP, User::ROLE_HEAD_OF_CYC_COM, User::ROLE_STUDENT, User::ROLE_TEACHER],
        ];
    }
}
