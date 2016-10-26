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
                    'label' => Yii::t('app', 'List'),
                    'url' => ['/students'],
                    'icon' => 'list',
                ],
                [
                    'label' => Yii::t('app', 'Import'),
                    'url' => ['/students/import'],
                    'icon' => 'list',
                ],
            ]
        ];
    }
}
