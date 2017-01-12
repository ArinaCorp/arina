<?php

namespace app\modules\plans\models\study_subject;

use yii\db\ActiveRecord;

use app\modules\directories\models\subject\Subject;
use app\modules\plans\models\study_plan\StudyPlan;

/**
 * @author Serhiy Vinichuk <serhiyvinichuk@gmail.com>
 * @copyright ХПК 2014
 *
 * This is the model class for table "sp_subject".
 *
 * The followings are the available columns in table 'sp_subject':
 * @property integer $id
 * @property integer $plan_id
 * @property integer $subject_id
 * @property integer $total
 * @property integer $lectures
 * @property integer $labs
 * @property integer $practs
 * @property integer $practice_weeks
 * @property array $weeks
 * @property array $control
 * @property bool $dual_labs
 * @property bool $dual_practice
 * @property string $diploma_name
 * @property string $certificate_name
 *
 * @property StudyPlan $plan
 * @property Subject $subject
 */
class StudySubject extends ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'sp_subject';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('plan_id, subject_id, total', 'required', 'message' => 'Вкажіть {attribute}'),
            array('weeks', 'check_weeks'),
            array('total', 'check_hours'),
            array('practice_weeks', 'check_practice'),
            array('lectures', 'check_classes'),
            array('subject_id', 'check_subject', 'on' => 'insert'),
            array('lectures, labs, practs', 'default', 'value' => 0, 'on' => 'insert'),
            array('plan_id, subject_id, total, lectures, labs, practs', 'numerical', 'integerOnly' => true),
            array('plan_id, subject_id, total, lectures, labs, practs, weeks, control, practice_weeks, dual_labs, dual_practice, diploma_name, certificate_name', 'safe'),
            array('id, plan_id, subject_id, total, lectures, labs, practs, subject', 'safe', 'on' => 'search'),
        );
    }

    public function getTitle()
    {
        return (!(empty($this->diploma_name) && empty($this->certificate_name)) ? '* ' : '') . $this->subject->title . (($this->dual_labs || $this->dual_practice) ? ' *' : '');
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'plan' => array(self::BELONGS_TO, 'StudyPlan', 'plan_id'),
            'subject' => array(self::BELONGS_TO, 'Subject', 'subject_id'),
        );
    }

    public function behaviors()
    {
        return array(
            'StrBehavior' => array(
                'class' => 'application.behaviors.StrBehavior',
                'fields' => array(
                    'weeks',

                ),
            ),
            'JSONBehavior' => array(
                'class' => 'application.behaviors.JSONBehavior',
                'fields' => array(
                    'control',
                ),
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'plan_id' => 'Plan',
            'subject_id' => Yii::t('terms', 'Subject'),
            'total' => 'Загальна кількість',
            'lectures' => 'Лекції',
            'labs' => 'Лабораторні',
            'practs' => 'Практичні, семінарські',
            'classes' => 'Всього аудиторних',
            'selfwork' => 'Самостійна робота',
            'testSemesters' => 'Залік',
            'examSemesters' => 'Екзамен',
            'workSemesters' => 'Курсова робота',
            'projectSemesters' => 'Курсовий проект',
            'practice_weeks' => 'Кількість тижнів для практики',
            'diploma_name' => 'Назва в дипломі',
            'certificate_name' => 'Назва в атестаті',
            'dual_labs' => 'Роздвоєння лабораторних',
            'dual_practice' => 'Роздвоєння практичних',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('plan_id', $this->plan_id);
        $criteria->compare('subject_id', $this->subject_id);
        $criteria->with('subject');
        $criteria->compare('subject.title', $this->subject_id, true);

        $sort = new CSort();
        $sort->attributes = array(
            'subject_id' => array(
                'asc' => 'subject.title ASC',
                'desc' => 'subject.title DESC',
            ),
        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    /**
     * @return int
     */
    public function getSelfwork()
    {
        return $this->total - $this->getClasses();
    }

    /**
     * @return int
     */
    public function getClasses()
    {
        return $this->lectures + $this->practs + $this->labs;
    }

    /**
     * Повертає список семестрів, в яких проводиться залік
     * @return string
     */
    public function getTestSemesters()
    {
        $semesters = array();
        foreach ($this->control as $semester => $control) {
            if (!empty($control[0])) {
                $semesters[] = $semester + 1;
            }
        }

        return implode(', ', $semesters);
    }

    /**
     * Повертає список семестрів, в яких проводиться екзамен
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
                $semesters[] = ($semester + 1) . ' ДПА';
            }
            if (!empty($control[3])) {
                $semesters[] = ($semester + 1) . ' ДА';
            }
        }
        return implode(', ', $semesters);
    }

    /**
     * Повертає список семестрів, в яких є курсова робота
     * @return string
     */
    public function getWorkSemesters()
    {
        $semesters = array();
        foreach ($this->control as $semester => $control) {
            if (!empty($control[4])) {
                $semesters[] = $semester + 1;
            }
        }
        return implode(', ', $semesters);
    }

    /**
     * Повертає список семестрів, в яких є курсовий проект
     * @return string
     */
    public function getProjectSemesters()
    {
        $semesters = array();
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

    public function check_hours()
    {
        if (!$this->hasErrors()) {
            if ($this->total < ($this->lectures + $this->labs + $this->practs)) {
                $this->addError('total', 'Аудиторних годин більше ніж загальна кількість');
            }
        }
    }

    public function check_practice()
    {
        if (!$this->hasErrors()) {
            if ($this->subject->practice) {
                if (empty($this->practice_weeks)) {
                    $this->addError('practice_weeks', 'Вкажіть кількість тижнів');
                }
                $valid = false;
                foreach ($this->control as $item) {
                    if (!empty($item[0])) {
                        $valid = true;
                        break;
                    }
                }
                if (!$valid) {
                    $this->addError('weeks', 'Вкажіть семестер практики');
                }
            }
        }
    }

    public function check_classes()
    {
        if (!$this->hasErrors()) {
            $sum = 0;
            foreach ($this->weeks as $semester => $weekly) {
                if (!empty($weekly)) {
                    $sum += $weekly * $this->plan->semesters[$semester];
                }
            }
            if (!$this->subject->practice && ($sum < $this->getClasses())) {
                $this->addError('lectures', 'Невистачає годин на тиждень для вичитки');
            }
        }
    }

    public function check_weeks()
    {
        if (!$this->hasErrors()) {
            $valid = false;
            foreach ($this->weeks as $week) {
                if (!empty($week)) {
                    $valid = true;
                }
            }
            if (!$valid && !$this->subject->practice) {
                $this->addError('weeks', 'Вкажіть кількість годин на тиждень у відповідних семестрах');
            }
        }
    }

    public function check_subject()
    {
        if (!$this->hasErrors()) {
            $criteria = new CDbCriteria();
            $criteria->condition = 'plan_id = :plan';
            $criteria->params[':plan'] = $this->plan_id;
            $criteria->addCondition('subject_id = :subject');
            $criteria->params[':subject'] = $this->subject_id;
            if (StudySubject::model()->exists($criteria)) {
                $this->addError('subject_id', 'Запис про цей предмет уже додано до цього навчального плану');
            }
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StudySubject the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
