<?php

namespace app\modules\students\models;

use app\modules\employee\models\Employee;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "curator_group".
 *
 * @property int $id
 * @property int $group_id
 * @property int $teacher_id
 * @property int $type
 * @property string $date
 * @property int $created_at
 * @property int $updated_at
 */
class CuratorGroup extends ActiveRecord
{
    const TYPE_ACCEPTED = 1;
    const TYPE_DE_ACCEPTED = 2;


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%curator_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'teacher_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
            [['group_id', 'teacher_id', 'type'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'type' => Yii::t('app', 'Type'),
            'date' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

//    public function getType()
//    {
//        return ($this->type) ? Yii::t('app', 'Accepted') : Yii::t('app', 'De accepted');
//    }

    public static function getTypesList()
    {
        return [
            self::TYPE_DE_ACCEPTED => Yii::t('app', 'De accepted'),
            self::TYPE_ACCEPTED => Yii::t('app', 'Accepted'),
        ];
    }

    public function getTeacher()
    {
        return $this->hasOne(Employee::className(), ['id' => 'teacher_id']);
    }

    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }
}
