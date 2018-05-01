<?php

namespace app\modules\rbac\models;

use Yii;

/**
 * This is the model class for table "{{%action_access_item}}".
 *
 * @property int $action_access_id
 * @property string $auth_item_name
 */
class ActionAccessItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%action_access_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_access_id', 'auth_item_name'], 'required'],
            [['action_access_id'], 'integer'],
            [['auth_item_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'action_access_id' => Yii::t('rbac', 'Action Access ID'),
            'auth_item_name' => Yii::t('rbac', 'Auth Item Name'),
        ];
    }

    public static function getActionItems($actionId)
    {
        return self::find()
            ->select(['auth_item_name'])
            ->where(['action_access_id' => $actionId])
            ->column();
    }
}
