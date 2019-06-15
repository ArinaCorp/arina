<?php

namespace app\modules\accounting\models;

use app\modules\directories\models\study_year\StudyYear;
use app\modules\employee\models\Employee;
use app\modules\load\models\Load;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "yearly_hour_accounting".
 *
 * @property int $id
 * @property int $study_year_id
 * @property int $teacher_id
 * @property int $created_at
 *
 * @property HourAccountingRecord[] $hourAccountingRecords
 * @property StudyYear $studyYear
 * @property Employee $teacher
 */
class YearlyHourAccounting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yearly_hour_accounting';
    }

    /**
     * {@inheritdoc}
     * @return YearlyHourAccountingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YearlyHourAccountingQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['study_year_id', 'teacher_id', 'updated_at', 'created_at'], 'integer'],
            [['study_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudyYear::class, 'targetAttribute' => ['study_year_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'study_year_id' => Yii::t('app', 'Study Year ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHourAccountingRecords()
    {
        return $this->hasMany(HourAccountingRecord::class, ['yearly_hour_accounting_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudyYear()
    {
        return $this->hasOne(StudyYear::class, ['id' => 'study_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Employee::class, ['id' => 'teacher_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $loads = Load::findAll([
                'employee_id' => $this->teacher_id,
                'study_year_id' => $this->study_year_id,
            ]);

            foreach ($loads as $load) {
                $record = new HourAccountingRecord([
                    'load_id' => $load->id,
                ]);
                $record->link('yearlyHourAccounting', $this);
                $record->save();
            }
        }
    }


}
