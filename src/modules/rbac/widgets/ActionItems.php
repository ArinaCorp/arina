<?php
namespace app\modules\rbac\widgets;

use app\modules\rbac\models\ActionAccess;
use app\modules\rbac\models\ActionAccessItem;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class ActionItems extends Widget
{
    public $actionId;

    /** @inheritdoc */
    public function init()
    {
        parent::init();
        if ($this->actionId === null) {
            throw new InvalidConfigException('You should set ' . __CLASS__ . '::$actionId');
        }
    }

    /** @inheritdoc */
    public function run()
    {
        $isUpdated = false;

        /** @var ActionAccess $model */
        $model = ActionAccess::findOne($this->actionId);
        $model->items = ActionAccessItem::getActionItems($this->actionId);

        if ($model->load(Yii::$app->request->post())) {
            $model->assignItems();
            $isUpdated = true;
        }

        return $this->render('form', [
            'model' => $model,
            'isUpdated' => $isUpdated,
        ]);
    }
}