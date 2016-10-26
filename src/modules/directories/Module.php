<?php

namespace app\modules\directories;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * directories module definition class
 */
class Module extends BaseModule implements IAdminModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\directories\controllers';


    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('app', 'Directories'),
            'icon' => 'tasks',
            'items' => [
                [
                    'label' => Yii::t('app', 'Audiences'),
                    'url' => ['/directories/audience'],
                    'icon' => 'folder',
                ],
                [
                    'label' => Yii::t('app', 'Subject'),
                    'url' => ['/directories/subject'],
                    'icon' => 'book',
                ],
                [
                    'label' => Yii::t('app', 'Department'),
                    'url' => ['/directories/department'],
                    'icon' => 'sticky-note',
                ],
                [
                    'label' => Yii::t('app', 'Speciality'),
                    'url' => ['/directories/speciality'],
                    'icon' => 'folder',
                ],
                [
                    'label' => Yii::t('app', 'Qualification'),
                    'url' => ['/directories/qualification'],
                    'icon' => 'folder',
                ],
                [
                    'label' => Yii::t('app', 'SpecialityQualification'),
                    'url' => ['/directories/speciality-qualification'],
                    'icon' => 'folder',
                ],
                [
                    'label' => Yii::t('app', 'Study years'),
                    'url' => ['/directories/study-year'],
                    'icon' => 'graduation-cap',
                ],
            ]
        ];
    }
}
