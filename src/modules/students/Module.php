<?php
/* @author VasyaKog */
namespace app\modules\students;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * students module definition class
 */
class Module extends BaseModule implements IAdminModule
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
                    'label' => Yii::t('app', 'Groups'),
                    'url' => ['/students/group'],
                    'icon' => 'street-view',
                ],
                [
                    'label' => Yii::t('app', 'List'),
                    'url' => ['/students'],
                    'icon' => 'address-book',
                ],
                [
                    'label' => Yii::t('app', 'Students history'),
                    'url' => ['/students/students-history'],
                    'icon' => 'random',
                ],
                [
                    'label' => Yii::t('app', 'Import Students from XML'),
                    'url' => ['/students/import'],
                    'icon' => 'download',
                ],
                [
                    'label' => Yii::t('app', 'Family ties types'),
                    'url' => ['/students/family-ties-types'],
                    'icon' => '',
                ],
                [
                    'label' => Yii::t('app', 'Exemptions'),
                    'url' => ['/students/exemptions'],
                    'icon' => 'universal-access',
                ],
                [
                    'label' => Yii::t('app', 'Curator Groups'),
                    'url' => ['/students/curator-groups'],
                    'icon' => 'sort',
                ]
            ]
        ];
    }
}
