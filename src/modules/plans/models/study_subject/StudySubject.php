<?php

namespace app\modules\plans\models\study_subject;

use Yii;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

use app\modules\directories\models\subject\Subject;
use app\modules\plans\models\study_plan\StudyPlan;

/**
 * This is the model class for table "study_subject".
 *
 * The followings are the available columns in table 'study_subject':
 * @property integer $id
 * @property integer $plan_id
 * @property integer $subject_id
 * @property integer $total
 * @property integer $lectures
 * @property integer $lab_works
 * @property integer $practices
 * @property integer $practice_weeks
 * @property array $weeks
 * @property array $control
 * @property bool $dual_lab_work
 * @property bool $dual_practice
 * @property string $diploma_name
 * @property string $certificate_name
 *
 * The followings are the available model relations:
 * @property StudyPlan $study_plan
 * @property Subject $subject
 */
class StudySubject extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%study_subject}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['plan_id, subject_id, total', 'required', 'message' => Yii::t('Plans', 'Specify').'{attribute}'],
            ['weeks', 'check_weeks'],
            ['total', 'check_hours'],
            ['practice_weeks', 'check_practice'],
            ['lectures', 'check_classes'],
            ['subject_id', 'check_subject', 'on' => 'insert'],
            ['lectures, lab_works, practices', 'default', 'value' => 0, 'on' => 'insert'],
            ['plan_id, subject_id, total, lectures, lab_works, practices', 'numerical', 'integerOnly' => true],
            ['plan_id, subject_id, total, lectures, lab_works, practices, weeks, control, practice_weeks, dual_lab_work, dual_practice, diploma_name, certificate_name', 'safe'],
            ['id, plan_id, subject_id, total, lectures, lab_works, practices, subject', 'safe', 'on' => 'search'],
        ];
    }

    public function getTitle()
    {
        return (!(empty($this->diploma_name) && empty($this->certificate_name)) ? '* ' : '') . $this->subject->title . (($this->dual_lab_work || $this->dual_practice) ? ' *' : '');
    }

    /**
     * @return ActiveQuery
     */
    public function getStudyPlan()
    {
        return $this->hasOne(StudyPlan::className(), ['id' => 'plan_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'StrBehavior' => [
                'class' => 'application.behaviors.StrBehavior',
                'fields' => [
                    'weeks',

                ],
            ],
            'JSONBehavior' => [
                'class' => 'application.behaviors.JSONBehavior',
                'fields' => [
                    'control',
                ],
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('Plans', 'ID'),
            'plan_id' => Yii::t('Plans', 'Plan'),
            'subject_id' => Yii::t('Plans', 'Subject'),
            'total' => Yii::t('Plans', 'Total'),
            'lectures' => Yii::t('Plans', 'Lectures'),
            'lab_works' => Yii::t('Plans', 'Laboratory works'),
            'practices' => Yii::t('Plans', 'Practice works'),
            'classes' => Yii::t('Plans', 'Class works'),
            'practice_weeks' => Yii::t('Plans', 'Practice weeks'),
            'diploma_name' => Yii::t('Plans', 'Diploma name'),
            'certificate_name' => Yii::t('Plans', 'Certificate name'),
            'dual_lab_work' => Yii::t('Plans', 'Dual laboratory works'),
            'dual_practice' => Yii::t('Plans', 'Dual practice works'),
            'self_work' => Yii::t('Plans', 'Self work'),
            'credit' => Yii::t('Plans', 'Credit'),
            'exam' => Yii::t('Plans', 'Exam'),
            'work_semester' => Yii::t('Plans', 'Work semester'),
            'project_semester' => Yii::t('Plans', 'Project semester'),
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StudySubject::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'plan_id' => $this->plan_id,
            'subject_id' => $this->subject_id,
            'total' => $this->total,
            'lectures' => $this->lectures,
            'lab_works' => $this->lab_works,
            'practices' => $this->practices,
            'practice_weeks' => $this->practice_weeks,
            'dual_lab_work' => $this->dual_lab_work,
            'dual_practice' => $this->dual_practice,
        ]);

        $query->andFilterWhere(['like', 'weeks', $this->weeks])
            ->andFilterWhere(['like', 'control', $this->control])
            ->andFilterWhere(['like', 'diploma_name', $this->diploma_name])
            ->andFilterWhere(['like', 'certificate_name', $this->certificate_name]);
        return $dataProvider;
    }

    /**
     * @return int
     */
    public function getSelfWork()
    {
        return $this->total - $this->getClasses();
    }

    /**
     * @return int
     */
    public function getClasses()
    {
        return $this->lectures + $this->practices + $this->lab_works;
    }

    /**
     * @return string
     */
    public function getTestSemesters()
    {
        $semesters = [];
        foreach ($this->control as $semester => $control) {
            if (!empty($control[0])) {
                $semesters[] = $semester + 1;
            }
        }

        return implode(', ', $semesters);
    }

    /**
     * @return string
     */
    public function getExamSemesters()
    {
        $semesters = array();
        foreach ($this->control as $semester => $control) {
            if (!empty($control[1])) {
                $semesters[] = $semester + 1;
            }
            if (!empty($control[2])) {
                $semesters[] = ($semester + 1) . Yii::t('Plans', 'State final examination');
            }
            if (!empty($control[3])) {
                $semesters[] = ($semester + 1) . Yii::t('Plans', 'State examination');
            }
        }
        return implode(', ', $semesters);
    }

    /**
     * @return string
     */
    public function getWorkSemesters()
    {
        $semesters = [];
        foreach ($this->control as $semester => $control) {
            if (!empty($control[4])) {
                $semesters[] = $semester + 1;
            }
        }
        return implode(', ', $semesters);
    }

    /**
     * @return string
     */
    public function getProjectSemesters()
    {
        $semesters = [];
        foreach ($this->control as $semester => $control) {
            if (!empty($control[5])) {
                $semesters[] = $semester + 1;
            }
        }
        return implode(', ', $semesters);
    }

    /**
     * @param $semester
     * @return string
     */
    public function getWeeklyHours($semester)
    {
        return isset($this->weeks[$semester]) ? $this->weeks[$semester] : '';
    }

    public function checkHours()
    {
        if (!$this->hasErrors()) {
            if ($this->total < ($this->lectures + $this->lab_works + $this->practices)) {
                $this->addError('total', Yii::t('Plans', 'Classroom hours more than the total number'));
            }
        }
    }

    public function checkPractice()
    {
        if (!$this->hasErrors()) {
            if ($this->subject->practice) {
                if (empty($this->practice_weeks)) {
                    $this->addError('practice_weeks', Yii::t('Plans','Specify the number of weeks'));
                }
                $valid = false;
                foreach ($this->control as $item) {
                    if (!empty($item[0])) {
                        $valid = true;
                        break;
                    }
                }
                if (!$valid) {
                    $this->addError('weeks', Yii::t('Plans', 'Add a semester of practice'));
                }
            }
        }
    }

    public function checkClasses()
    {
        if (!$this->hasErrors()) {
            $sum = 0;
            foreach ($this->weeks as $semester => $weekly) {
                if (!empty($weekly)) {
                    $sum += $weekly * $this->study_plan->semesters[$semester];
                }
            }
            if (!$this->subject->practice && ($sum < $this->getClasses())) {
                $this->addError('lectures', Yii::t('Plans', 'Not enough hours a week for proofreading'));
            }
        }
    }

    public function checkWeeks()
    {
        if (!$this->hasErrors()) {
            $valid = false;
            foreach ($this->weeks as $week) {
                if (!empty($week)) {
                    $valid = true;
                }
            }
            if (!$valid && !$this->subject->practice) {
                $this->addError('weeks', Yii::t('Plans', 'Specify the number of hours per week in the corresponding semester'));
            }
        }
    }

}
