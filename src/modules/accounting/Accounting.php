<?php

namespace app\modules\accounting;
use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;
/**
 * accounting module definition class
 */
class Accounting extends BaseModule implements IAdminModule
{

    public function behaviors()
    {
        return [
           // 'as AccessBehavior' => [
           //     'class' => \developeruz\db_rbac\behaviors\AccessBehavior::className(),
          //  ]
        ];
    }

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\accounting\controllers';

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('app', 'Accounting'),
            'icon' => 'sticky-note',
            'items' => [
                /*[
                    'label' => Yii::t('app', 'Accounting teacher training hours per mounth'),
                    'url' => ['/accounting/accounting-mounth'],
                    'icon' => 'list',
                ],
                [
                    'label' => Yii::t('app', 'Accounting teacher training hours per year'),
                    'url' => ['/accounting/accounting-year'],
                    'icon' => 'list',
                ],*/
                [
                    'label' => Yii::t('app', 'Accounting per mounth'),
                    'url' => ['/accounting/accounting'],
                    'icon' => 'list',
                ],
                [
                    'label' => Yii::t('app', 'Accounting teacher training hours per year'),
                    'url' => ['/accounting/accounting-ye'],
                    'icon' => 'list',
                ],
            ]
        ];
    }
}
