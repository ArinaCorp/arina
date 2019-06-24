<?php

namespace app\modules\journal;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * journal module definition class
 */
class Module extends BaseModule implements IAdminModule
{
    public $controllerAliases = [
        '@app/modules/journal/controllers',
    ];

    public function behaviors()
    {
        return [
            //           'as AccessBehavior' => [
            //               'class' => \developeruz\db_rbac\behaviors\AccessBehavior::class,
            //           ]
        ];
    }

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\journal\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('app', 'Journal'),
            'icon' => 'book',
            'items' => [
                [
                    'label' => Yii::t('app', 'Marks accounting'),
                    'url' => ['/journal/marks-accounting'],
                    'icon' => 'files-o',
                    'roles' => ['teacher'],
                ],
                [
                    'label' => Yii::t('app', 'Evaluation systems'),
                    'url' => ['/journal/evaluation-systems'],
                    'icon' => 'tag',
                ],
                [
                    'label' => Yii::t('app', 'Evaluations'),
                    'url' => ['/journal/evaluations'],
                    'icon' => 'graduation-cap',
                ],
                [
                    'label' => Yii::t('app', 'Journal Record Types'),
                    'url' => ['/journal/journal-record-type'],
                    'icon' => 'bookmark',
                ],
//                [
//                    'label' => Yii::t('app', 'Not Presence Types'),
//                    'url' => ['/journal/presence-type'],
//                    'icon' => 'times-rectangle-o',
//                ],
            ],
            'roles' => ['teacher'],
        ];
    }
}
