<?php

namespace app\modules\geo;

use nullref\core\interfaces\IAdminModule;
use rmrevin\yii\fontawesome\FA;
use Yii;
use yii\base\Module as BaseModule;

/**
 * geo module definition class
 */
class Module extends BaseModule implements IAdminModule
{

    public function behaviors()
    {
        return [
//            'as AccessBehavior' => [
//                'class' => \developeruz\db_rbac\behaviors\AccessBehavior::class,
//        ]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\geo\controllers';
    public $modelsNamespace = 'app\modules\geo\models';

    /**
     * @inheritdoc
     */
    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('app', 'Geo'),
            'icon' => FA::_GLOBE,
            'order' => 2,
            'items' => [
                'countries' => [
                    'label' => \Yii::t('app', 'Countries'),
                    'url' => ['/geo/admin/country'],
                    'icon' => FA::_FLAG_O,
                ],
                'regions' => [
                    'label' => \Yii::t('app', 'Regions'),
                    'url' => ['/geo/admin/region'],
                    'icon' => FA::_MAP_O,
                ],
                'districts' => [
                    'label' => \Yii::t('app', 'Districts'),
                    'url' => ['/geo/admin/district'],
                    'icon' => FA::_MAP_O,
                ],
                'cities' => [
                    'label' => \Yii::t('app', 'Cities'),
                    'url' => ['/geo/admin/city'],
                    'icon' => FA::_MAP_MARKER,
                ],
                'villages' => [
                    'label' => \Yii::t('app', 'Villages'),
                    'url' => ['/geo/admin/village'],
                    'icon' => FA::_MAP_MARKER,
                ],
                'smts' => [
                    'label' => \Yii::t('app', 'Smts'),
                    'url' => ['/geo/admin/smt'],
                    'icon' => FA::_MAP_MARKER,
                ]
            ]
        ];
    }
}
