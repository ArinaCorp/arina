<?php
/* @author VasyaKog */

namespace app\modules\students;

use app\modules\rbac\interfaces\IAccessibleModule;
use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * students module definition class
 */
class Module extends BaseModule implements IAdminModule, IAccessibleModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\students\controllers';

    /**
     * @inheritdoc
     */
    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('app', 'Students'),
            'icon' => 'users',
            'items' => [
                [
                    'label' => Yii::t('app', 'List'),
                    'url' => ['/students/default/index'],
                    'icon' => 'address-book',
                    'roles' => ['head-of-department', 'staff-office'],
                ],
                [
                    'label' => Yii::t('app', 'Groups'),
                    'url' => ['/students/group/index'],
                    'icon' => 'street-view',
                    'roles' => ['head-of-department', 'teacher', 'curator'],
                ],
                [
                    'label' => Yii::t('app', 'Students history'),
                    'url' => ['/students/students-history'],
                    'icon' => 'random',
                ],
                [
                    'label' => Yii::t('app', 'Students Import'),
                    'icon' => 'download',
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Import Students from XML'),
                            'url' => ['/students/import'],
                            'icon' => 'download',
                        ],
                        [
                            'label' => Yii::t('app', 'Import Students from CSV'),
                            'url' => ['/students/csv-import-document'],
                            'icon' => 'download',
                        ],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Exemptions journal'),
                    'url' => ['/students/exemption-student-relations'],
                    'icon' => 'universal-access',
                ],
                [
                    'label' => Yii::t('app', 'Curator Groups'),
                    'url' => ['/students/curator-groups'],
                    'icon' => 'sort',
                ],
                [
                    'label' => Yii::t('app', 'Directories'),
                    'icon' => 'tasks',
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Family ties types'),
                            'url' => ['/students/family-relation-type'],
                            'icon' => 'home',
                        ],
                        [
                            'label' => Yii::t('app', 'Exemptions types'),
                            'url' => ['/students/exemptions'],
                            'icon' => 'universal-access',
                        ],
                        [
                            'label' => Yii::t('app', 'Social Networks'),
                            'url' => ['/students/social-networks'],
                            'icon' => 'users',
                        ],
                        [
                            'label' => Yii::t('app', 'Characteristics Types'),
                            'url' => ['/students/characteristics-type'],
                            'icon' => 'file-text-o',
                        ],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Student card'),
                    'url' => ['/students/student-card'],
                    'icon' => 'address-book',
                ],
            ],
            'roles' => ['head-of-department', 'teacher', 'curator', 'staff-office'],
        ];
    }

    /**
     * @return array
     */
    public static function getAccessibleControllerAliases()
    {
        return [
            '@app/modules/students/controllers',
        ];
    }
}
