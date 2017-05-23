<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%exemptions_students_relations}}".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $exemption_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class ExemptionStudentRelation extends \yii\db\ActiveRecord
{
    public $group_id;

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
        return '{{%exemptions_students_relations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'exemption_id', 'created_at', 'updated_at'], 'integer'],
            [['date_start', 'date_end', 'information'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'exemption_id' => Yii::t('app', 'Exemption ID'),
            'date_start' => Yii::t('app', 'Start date of exemptions'),
            'date_end' => Yii::t('app', 'End date of exemptions'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
