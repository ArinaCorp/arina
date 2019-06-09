<?php

namespace app\modules\directories\models;

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\load\models\Load;
use app\modules\plans\models\WorkPlan;
use nullref\useful\traits\Mappable;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "study_years".
 *
 * @property integer $id
 * @property integer $year_start
 * @property integer $active
 *
 * @property WorkPlan[] $workPlans
 * @property Load[] $loads
 */
class StudyYear extends ActiveRecord
{
    use Mappable;

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
     * @return string
     */
    public function getTitle()
    {
        $yearEnd = $this->year_start + 1;
        return "$this->year_start/$yearEnd";
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'year_start' => Yii::t('app', 'Start of the study year'),
            'yearEnd' => Yii::t('app', 'End of the study year'),
            'active' => Yii::t('app', 'Current'),
            'title' => Yii::t('app', 'Study year'),
        ];
    }

    /**
     * @return int
     */
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
     * @return ActiveQuery
     */
    public static function find()
    {
        return parent::find();
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
            $items[$studyYear->id] = $studyYear->getTitle();
        }
        return $items;
    }

    /**
     * @return ActiveQuery
     */
    public function getWorkPlans()
    {
        return $this->hasMany(WorkPlan::class, ['study_year_id' => 'id'])->alias('workPlans');
    }

    /**
     * @return ActiveQuery
     */
    public function getLoads()
    {
        return $this->hasMany(WorkPlan::class, ['study_year_id' => 'id'])->alias('loads');
    }

    /**
     * @return StudyYear|static
     */
    public static function getActiveYear()
    {
        $cur_year = self::findOne(['active' => 1]);
        return $cur_year;
    }

    /**
     * @param $speciality_qualification_id
     * @param null $year_id
     * @return array
     */
    public static function getListGroupByYear($speciality_qualification_id, $year_id = null)
    {
        $specialityQualification = SpecialityQualification::findOne($speciality_qualification_id);
        if (is_null($speciality_qualification_id)) {
            return [];
        }
        return $specialityQualification->getGroupsActiveList($year_id);
    }
}
