<?php

namespace app\modules\directories\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

use app\modules\plans\models\WorkPlan;

/**
 * This is the model class for table "study_years".
 *
 * @property integer $id
 * @property integer $year_start
 * @property integer $active
 *
 * @property WorkPlan[] $workPlans
 */
class StudyYear extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%study_years}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['year_start', 'required'],
            [['year_start'], 'integer'],
            ['active', 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'year_start' => Yii::t('app', 'Start of the study year'),
            'yearend' => Yii::t('app', 'End of the study year'),
            'active' => Yii::t('app', 'Current'),
            'fullName' => Yii::t('app', 'Study year'),
        ];
    }

    public function getYearEnd()
    {
        return $this->year_start + 1;
    }

    /**
     * @return string
     */
    public function getYearPrefix()
    {
        $str = (string)$this->year_start;
        return $str[sizeof($this) - 2] . $str[sizeof($this) - 1];
    }

    /**
     * @return array
     */
    public static function getYearList()
    {
        $studyYears = StudyYear::find()->all();
        $items = [];
        foreach ($studyYears as $studyYear) {
            /**
             * @var StudyYear $studyYear
             */
            $items[$studyYear->id] = $studyYear->getFullName();
        }
        return $items;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->year_start . '/' . $this->getYearEnd();
    }

    /**
     * @return ActiveQuery
     */
    public function getStudySubject()
    {
        return $this->hasMany(WorkPlan::className(), ['year_id' => 'id'])->via('work_plans');
    }

    /**
     * @return StudyYear|static
     */
    public static function getCurrentYear()
    {
        $cur_year = self::findOne(['active' => 1]);
        return $cur_year;
    }

    /**
     * @return mixed
     */
    public static function getList()
    {
        return ArrayHelper::map(StudyYear::find()->all(), 'id', 'year_start');
    }
}
