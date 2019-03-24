<?php

namespace app\modules\directories\models\speciality_qualification;

use app\modules\directories\models\department\Department;
use app\modules\directories\models\qualification\Qualification;
use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\subject_relation\SubjectRelation;
use app\modules\students\models\Group;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
 * @property Speciality $speciality
 * @property Qualification $qualification
 * @property SubjectRelation[] $relations
 * @property Group[] $groups
 */
class SpecialityQualification extends ActiveRecord
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
            [['title', 'years_count', 'months_count', 'speciality_id', 'qualification_id'], 'required'],
            [['years_count', 'months_count', 'speciality_id', 'qualification_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return int
     */
    public function getCountCourses()
    {
        $count = $this->years_count + 0;
        if ($this->months_count > 0) {
            $count++;
        }
        return $count + 0;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'years_count' => Yii::t('app', 'Years Count'),
            'months_count' => Yii::t('app', 'Months Count'),
            'qualification_id' => Yii::t('app', 'Qualification ID'),
            'speciality_id' => Yii::t('app', 'Speciality ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQualification()
    {
        return $this->hasOne(Qualification::class, ['id' => 'qualification_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeciality()
    {
        return $this->hasOne(Speciality::class, ['id' => 'speciality_id']);
    }

    /**
     * @return array
     */
    public static function getTreeList()
    {
        $list = [];

        /* @var $departments Department[] */

        $departments = Department::find()->all();

        if (!Yii::$app->user->isGuest) {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            if (UserHelper::hasRole($user, 'head-of-department')) {
                $departments = Department::find()
                    ->andWhere(['head_id' => $user->employee->id])
                    ->all();
            }
        }

        foreach ($departments as $department) {
            $list[$department->title] = [];
            foreach ($department->specialities as $speciality) {
                $list[$department->title][$speciality->title] = [];
                foreach ($speciality->specialityQualifications as $specialityQualification) {
                    $list[$department->title][$speciality->title][$specialityQualification->id] = $specialityQualification->title;
                }
            }
        }
        return $list;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectRelation()
    {
        return $this->hasMany(SubjectRelation::class, ['speciality_qualification_id' => 'id']);
    }

    /**
     * @param $f1 SpecialityQualification
     * @param $f2 SpecialityQualification
     * @return int
     */
    public function compare($f1, $f2)
    {
        if ($f1->qualification->sort_order < $f2->qualification->sort_order) {
            return -1;
        } elseif ($f1->qualification->sort_order > $f2->qualification->sort_order) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @return bool|int
     */
    public function getOffsetYears()
    {
        $currentSpeciality = $this->speciality;
        $offset = 0;

        $qualifications = $currentSpeciality->specialityQualifications;
        usort($qualifications, [$this, 'compare']);
        foreach ($qualifications as $qualification) {
            if ($qualification->id == $this->id) return $offset;
            $offset += $qualification->getCountCourses();
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::class, ['speciality_qualifications_id' => 'id']);
    }

    /**
     * @param null $year_id
     * @return Group[]
     */
    public function getGroupsActive($year_id = null)
    {
        $array = $this->groups;
        /**
         * @var Group[] $array
         */
        foreach ($array as $key => $item) {
            if (!$item->isActive($year_id)) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * @param null $year_id
     * @return array
     */
    public function getGroupsActiveList($year_id = null)
    {
        return ArrayHelper::map($this->getGroupsActive($year_id), 'id', 'title');
    }

    /**
     * @param $yearId
     * @return array
     */
    public function getGroupsByStudyYear($yearId)
    {
        $list = [];
        echo '<br>getGroupsByStudyYear<br>';

        foreach ($this->groups as $group) {
//            var_dump(Group::findOne(1)->getCourse($yearId)<5); die;
//            var_dump($group->getCourse($yearId));
            if ($group->getCourse($yearId) < 5) {
//                if ($group->id == 1) echo $group->getSystemTitle();
                $list[$group->getSystemTitle()] = $group->getCourse($yearId);
            }
        }
//        var_dump($list);
//        die;
        array_multisort($list);
        return $list;
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return ArrayHelper::map(SpecialityQualification::find()->all(), 'id', 'title');
    }

}
