<?php

namespace app\modules\students\models;

use app\modules\employee\models\Employee;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "curator_group".
 *
 * @property int $id$group_id
 * @property int
 * @property int $teacher_id
 * @property int $type
 * @property string $date
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Group $group;
 */
class CuratorGroup extends ActiveRecord
{
    const TYPE_ACCEPTED = 1;
    const TYPE_DE_ACCEPTED = 2;


    public function behaviors()
    {
        return [
            TimestampBehavior::class,
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

    /**
     * @return array
     */
    public static function getTypesList()
    {
        return [
            self::TYPE_DE_ACCEPTED => Yii::t('app', 'De accepted'),
            self::TYPE_ACCEPTED => Yii::t('app', 'Accepted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Employee::class, ['id' => 'teacher_id']);
    }

    /**
     * Set or unset curator id at group record
     *
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->isNewRecord) {
            if ($group = $this->group) {
                if ($this->type === self::TYPE_ACCEPTED) {
                    $group->curator_id = $this->teacher_id;
                } else {
                    $group->curator_id = null;
                }
                $group->save(false, ['curator_id']);
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }
}
