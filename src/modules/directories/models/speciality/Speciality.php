<?php

namespace app\modules\directories\models\speciality;

use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

use app\modules\directories\models\department\Department;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\qualification\Qualification;
use app\modules\students\models\Group;
use app\modules\plans\models\StudyPlan;
use app\modules\plans\models\WorkPlan;

/**
 * This is the model class for table "speciality".
 *
 * @property integer $id
 * @property string $title
 * @property integer $department_id
 * @property integer $number
 * @property string $accreditation_date
 *
 * The followings are the available model relations:
 * @property Department $department
 * @property SpecialityQualification[] $specialityQualifications
 * @property StudyPlan[] $studyPlans
 * @property WorkPlan[] $workPlans
 */
class Speciality extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%speciality}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id'], 'integer'],
            [['accreditation_date'], 'safe'],
            [['title', 'number', 'short_title'], 'string', 'max' => 255],
            [['department_id', 'title', 'short_title'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecialityQualifications()
    {
        return $this->hasMany(SpecialityQualification::className(), ['speciality_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQualification()
    {
        return $this->hasMany(Qualification::className(), ['id' => 'qualification_id'])
            ->via('specialityQualifications');
    }

    /**
     * @return array
     */
    public static function getSpecialityTreeList()
    {
        $list = [];
        $department = Department::find()->all();
        foreach ($department as $item) {
            /* @var $item Department */
            $list[$item->title] = [];
            foreach ($item->specialities as $speciality) {
                /**
                 * @var $speciality Speciality
                 */
                $list[$item->title][$speciality->id] = $speciality->title;
            }
        }
        return $list;

    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'department_id' => Yii::t('app', 'Department'),
            'number' => Yii::t('app', 'Number'),
            'accreditation_date' => Yii::t('app', 'Accreditation Date'),
            'short_title' => Yii::t('app', 'Short Title'),
        ];
    }

    /**
     * @inheritdoc
     * @return SpecialityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SpecialityQuery(get_called_class());
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->accreditation_date = date('Y-m-d', strtotime($this->accreditation_date));
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        $this->accreditation_date = date('d.m.Y', strtotime($this->accreditation_date));
    }

    /**
     * @return string
     */
    public function getSpecialityQualificationsLinks(){
        $list = "";
        foreach ($this->specialityQualifications as $specialityQualification){
            /**
             * @var $specialityQualification SpecialityQualification
             */
            $list.=Html::a($specialityQualification->title, Url::to(['/admin/directories/speciality-qualification','id'=>$specialityQualification->id])).'<br/>';
        }
        return $list;
    }

    /**
     * @param $yearId
     * @return array
     */
    public function getGroupsByStudyYear($yearId)
    {
        $list = [];
        foreach ($this->specialityQualifications as $sQ) {
            foreach ($sQ->groups as $group) {
                $list[$group->title] = $group->getCourse($yearId);
            }
        }
        array_multisort($list);
        return $list;
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return ArrayHelper::map(Speciality::find()->all(), 'id', 'title');

    }
}
