<?php

namespace app\modules\directories\models\speciality_qualification;

use app\modules\students\models\Group;
use Yii;
use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\qualification\Qualification;
use app\modules\directories\models\department\Department;

/**
 * This is the model class for table "speciality_qualification".
 *
 * @property integer $id
 * @property string $title
 * @property integer $years_count
 * @property integer $months_count  
 * @property integer $qualification_id
 * @property integer $speciality_id
 *
 * @property $speciality Speciality
 * @property $qualification Qualification
 * @property $relations SubjectRelation[]
 * @property $groups Group[]
 */
class SpecialityQualification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%speciality_qualification}}';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['years_count', 'months_count', 'speciality_id', 'qualification_id'], 'required'],
            [['years_count', 'months_count', 'speciality_id', 'qualification_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */


    public function getCountCourses()
    {
        $count = $this->years_count;
        if ($this->months_count > 0) {
            $count++;
        }
        return $count;
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'years_count' => Yii::t('app', 'Years Count'),
            'months_count' => Yii::t('app', 'Months Count'),
        ];
    }

    public function getQualification()
    {
        return $this->hasOne(Qualification::className(), ['id' => 'qualification_id']);
    }

    public function getSpeciality()
    {
        return $this->hasOne(Speciality::className(), ['id' => 'speciality_id']);
    }

    public static function getTreeList()
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
                $list[$item->title][$speciality->title] = [];
                foreach ($speciality->specialityQualifications as $specialityQualification) {
                    /**
                     * @var $specialityQualification SpecialityQualification
                     */
                    $list[$item->title][$speciality->title][$specialityQualification->id] = $specialityQualification->title;
                }
            }
        }
        return $list;
    }

    public function getSubjectRelation()
    {
        return $this->hasMany(SubjectRelation::className(), ['speciality_qualification_id' => 'id']);
    }

    public  function compare($f1, $f2)
    {
        /**
         * @var $f1 SpecialityQualification
         * @var $f2 SpecialityQualification
         */
        if ($f1->qualification->sort_order < $f2->qualification->sort_order) return -1;
        elseif ($f1->qualification->sort_order > $f2->qualification->sort_order) return 1;
        else return 0;
    }

    public function getOffsetYears()
    {
        /**
         * @var $currentSpeciality Speciality;
         */
        $currentSpeciality = $this->speciality;
        $offset = 0;


        // uasort – сортирует массив, используя пользовательскую функцию mySort

        $qualifications = $currentSpeciality->specialityQualifications;
        usort($qualifications, [$this ,'compare']);
        foreach ($qualifications as $qualification) {
            /**
             * @var $qualification SpecialityQualification
             */
            if ($qualification->id == $this->id) return $offset;
            $offset += $qualification->getCountCourses();
        }
        return false;
    }
    public function getGroups(){
        return $this->hasMany(Group::className(),['speciality_qualifications_id' => 'id']);
    }
}
