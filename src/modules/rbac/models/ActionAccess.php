<?php

namespace app\modules\rbac\models;

use Yii;

/**
 * This is the model class for table "{{%action_access}}".
 *
 * @property integer $id
 * @property string $module
 * @property string $controller
 * @property string $action
 *
 * @property AuthItem[] $authItems
 */
class ActionAccess extends \yii\db\ActiveRecord
{
    public $items;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%action_access}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module', 'controller', 'action'], 'string', 'max' => 255],
            [['items'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rbac', 'ID'),
            'module' => Yii::t('rbac', 'Module'),
            'controller' => Yii::t('rbac', 'Controller'),
            'action' => Yii::t('rbac', 'Action'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'auth_item_name'])
            ->viaTable(ActionAccessItem::tableName(), ['action_access_id' => 'id']);
    }

    public function assignItems()
    {
        if (!is_array($this->items)) {
            $this->items = [];
        }

        $oldItems = ActionAccessItem::getActionItems($this->id);

        //Add new items
        $itemsToAdd = [];
        foreach (array_diff($this->items, $oldItems) as $itemName) {
            $newItem = new ActionAccessItem([
                'action_access_id' => $this->id,
                'auth_item_name' => $itemName,
            ]);
            $newItem->save();
        }

        //Remove items
        $itemsToRemove = [];
        foreach (array_diff($oldItems, $this->items) as $itemName) {
            $itemsToRemove[] = $itemName;
        }
        ActionAccessItem::deleteAll(['auth_item_name' => $itemsToRemove, 'action_access_id' => $this->id]);

        return true;
    }
}
