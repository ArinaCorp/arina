<?php

namespace app\modules\directories\models\study_year;

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\study_year\StudyYearQuery;
use app\modules\load\models\Load;
use app\modules\plans\models\WorkPlan;
use nullref\useful\traits\Mappable;
use phpDocumentor\Reflection\Types\Self_;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "study_years".
 *
 * @property integer $id
 * @property integer $year_start
 * @property integer $active
 * @property string $title
 *
 * @property WorkPlan[] $workPlans
 * @property Load[] $loads
 */
class StudyYear extends ActiveRecord
{
    use Mappable;

    const ACTIVE = 1;
    const INACTIVE = 0;

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
            ['year_start', 'integer'],
            ['active', 'boolean'],
        ];
    }

    public static function find()
    {
        return new StudyYearQuery(get_called_class());
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
            'yearend' => Yii::t('app', 'End of the study year'),
            'active' => Yii::t('app', 'Current'),
            'fullName' => Yii::t('app', 'Study year'),
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
    public static function getCurrentYear()
    {
        return self::findOne(['active' => self::ACTIVE]);
    }

    /**
     * Reassignment current year
     * Get previous current year and set its inactive
     * Set new year as current
     * @return bool
     */
    public function setCurrent()
    {
        $currentYear = StudyYear::getCurrentYear();
        $currentYear->active = self::INACTIVE;
        $currentYear->save();

        $this->active = self::ACTIVE;
        return $this->save();
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
