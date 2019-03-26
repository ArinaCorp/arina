<?php

namespace app\modules\directories\models\subject_block;

use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\subject\Subject;
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
 * @property integer $speciality_id
 * @property integer $course
 * @property string $title
 * @property string $created
 *
 * @property Subject[] $subjects
 * @property Speciality $speciality
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
            [['id'], 'integer'],
            [['speciality_id'], 'integer'],
            [['speciality_id', 'course'], 'required'],
            [['course'], 'integer', 'min' => 1, 'max' => 4],
            [['created'], 'string'],
            ['selectedSubjects', 'each', 'rule' => ['integer']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'speciality_id' => Yii::t('app', 'Speciality'),
            'course' => Yii::t('app', 'Course'),
            'selectedSubjects' => Yii::t('app', 'Selected subject'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjects()
    {
        return $this->hasMany(Subject::className(), ['id' => 'subject_id'])->viaTable('subject_to_block', ['block_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeciality()
    {
        return $this->hasOne(Speciality::className(), ['id' => 'speciality_id']);
    }

    /**
     * @return string Speciality title
     */
    public function getSpecialityTitle()
    {
        return $this->speciality->title;
    }

    public function getSubjectsDetail()
    {
        $details = [];
        foreach ($this->subjects as $subject)
            $details[] =
                [
                    'label' => $subject->code,
                    'value' => $subject->title,
                ];
        return $details;
    }

    /**
     * Save multiselected subjects in form;
     * subject's non/existence is checked.
     *
     * @param $update bool
     * @return bool
     */
    public function saveSelectedSubjects($update = false)
    {
        try {
            if ($update) {
                foreach ($this->subjects as $subject) {
                    if (!in_array($subject->id, $this->selectedSubjects)) {
                        $this->unlink('subjects', $subject, true);
                    }
                }
            }
            foreach ($this->selectedSubjects as $subjectId) {
                if (!$this->getSubjects()->where(['id' => $subjectId])->exists()) {
                    $this->link('subjects', Subject::findOne($subjectId));
                }
            }
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getSubjectCount()
    {
        return count($this->subjects);
    }

    /**
     * @param $studentId
     * @return SubjectBlock[]
     */
    public static function getSubjectBlocksForStudent($studentId)
    {
        $student = Student::findOne($studentId);
        /** @var Group $group */
        $group = $student->getGroups()[0];
        return ArrayHelper::Map(SubjectBlock::findAll(['course'=>$group->getCourse(), 'speciality_id' => $group->specialityQualification->speciality_id]), 'id','created');
    }



}
