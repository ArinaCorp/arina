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
                    'icon' => 'building',
                ],
                [
                    'label' => Yii::t('app', 'Subject'),
                    'url' => ['/directories/subject'],
                    'icon' => 'book',
                ],
                [
                    'label' => Yii::t('app', 'Departments'),
                    'url' => ['/directories/department'],
                    'icon' => 'sticky-note',
                ],
                [
                    'label' => Yii::t('app', 'Specialities'),
                    'url' => ['/directories/speciality'],
                    'icon' => 'archive',
                ],
                [
                    'label' => Yii::t('app', 'Qualifications'),
                    'url' => ['/directories/qualification'],
                    'icon' => 'file-text',
                ],
                [
                    'label' => Yii::t('app', 'Speciality Qualifications'),
                    'url' => ['/directories/speciality-qualification'],
                    'icon' => 'graduation-cap',
                ],
                [
                    'label' => Yii::t('app', 'Study years'),
                    'url' => ['/directories/study-year'],
                    'icon' => 'graduation-cap',
                ],
                [
                    'label' => Yii::t('app', 'Position'),
                    'url' => ['/directories/position'],
                    'icon' => 'graduation-cap',
                ],
            ]
        ];
    }
}
