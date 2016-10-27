<?php

namespace app\modules\students\models;

use Yii;

/**
 * This is the model class for table "{{%student_group}}".
 *
 * @property integer $id
 * @property string $string
 * @property integer $type
 * @property integer $group_id
 * @property integer $student_id
 * @property string $comment
 * @property integer $funding_id
 */
class StudentGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%student_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['string'], 'safe'],
            [['type', 'group_id', 'student_id', 'funding_id'], 'integer'],
            [['comment'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'string' => Yii::t('app', 'String'),
            'type' => Yii::t('app', 'Type'),
            'group_id' => Yii::t('app', 'Group ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'comment' => Yii::t('app', 'Comment'),
            'funding_id' => Yii::t('app', 'Funding ID'),
        ];
    }
}
