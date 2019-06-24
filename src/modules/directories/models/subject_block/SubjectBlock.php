<?php

namespace app\modules\directories\models\subject_block;

use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\subject\Subject;
use app\modules\plans\components\Calendar;
use app\modules\plans\models\WorkPlan;
use app\modules\plans\models\WorkSubject;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use app\modules\students\models\StudentsHistory;
use nullref\useful\traits\Mappable;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\bootstrap\Alert;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "subject_block".
 *
 * @property integer $id
 * @property integer $speciality_qualification_id
 * @property integer $course
 * @property string $title
 * @property string $created
 *
 * @property WorkSubject[] $workSubjects
 * @property SpecialityQualification $specialityQualification
 *
 * @property WorkPlan $workPlan
 *
 * Form property
 * @property int[] $selectedSubjects
 */
class SubjectBlock extends ActiveRecord
{
    use Mappable;

    public $selectedSubjects;

    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subject_block}}';
    }

    /**
     * @inheritdoc
     * @return SubjectBlockQuery
     */
    public static function find()
    {
        return new SubjectBlockQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_plan_id'], 'integer'],
            [['work_plan_id', 'course'], 'required'],
            [['course'], 'integer', 'min' => 1, 'max' => 4],
            [['semester'], 'integer', 'min' => 1, 'max' => 2],
            ['selectedSubjects', 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'work_plan_id' => Yii::t('plans', 'Work plan'),
            'course' => Yii::t('app', 'Course'),
            'semester' => Yii::t('app', 'Semester'),
            'selectedSubjects' => Yii::t('app', 'Selected subject'),
            'created' => Yii::t('app', 'Created At'),
            'updated' => Yii::t('app', 'Updated At'),
            'subjectCount' => Yii::t('app', 'Subject count'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkSubjects()
    {
        return $this->hasMany(WorkSubject::className(), ['id' => 'work_subject_id'])->viaTable('work_subject_to_subject_block', ['block_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkPlan()
    {
        return $this->hasOne(WorkPlan::class, ['id' => 'work_plan_id']);
    }

    /**
     * @return string
     */
    public function getWorkPlanTitle()
    {
        return $this->workPlan->getTitle();
    }

    public function getSubjectsDetail()
    {
        $details = [];
        foreach ($this->workSubjects as $workSubject)
            $details[] =
                [
                    'label' => $workSubject->subject->code,
                    'value' => $workSubject->title,
                ];
        return $details;
    }

    /**
     * Save multi-selected subjects in form;
     * subject's non/existence is checked.
     *
     * @param $update bool
     * @return bool
     */
    public function saveSelectedSubjects($update = false)
    {
        try {
            if ($update) {
                foreach ($this->workSubjects as $workSubject) {
                    if (!in_array($workSubject->id, $this->selectedSubjects)) {
                        $this->unlink('workSubjects', $workSubject, true);
                    }
                }
            }
            foreach ($this->selectedSubjects as $workSubjectId) {
                if (!$this->getWorkSubjects()->where(['id' => $workSubjectId])->exists()) {
                    $this->link('workSubjects', WorkSubject::findOne($workSubjectId));
                }
            }
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getSubjectCount()
    {
        return count($this->workSubjects);
    }

}
