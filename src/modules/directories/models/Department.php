<?php

namespace app\modules\directories\models;

/**
 * This is the model class for table "department".
 *
 * @property integer $id
 * @property string $title
 * @property integer $head_id
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['head_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'head_id' => 'Head ID',
        ];
    }
}
