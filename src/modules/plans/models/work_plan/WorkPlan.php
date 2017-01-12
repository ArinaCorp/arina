<?php

namespace app\modules\plans\models\work_plan;

/**
 * @author Serhiy Vinichuk <serhiyvinichuk@gmail.com>
 * @copyright ХПК 2014
 *
 * This is the model class for table "wp_plan".
 *
 * The followings are the available columns in table 'wp_plan':
 * @property integer $id
 * @property integer $speciality_id
 * @property array $semesters
 * @property array $graph
 * @property integer $created
 * @property integer $updated
 * @property integer $year_id
 *
 * The followings are the available model relations:
 * @property StudyYear $year
 * @property WorkSubject[] $subjects
 * @property Speciality $speciality
 */
class WorkPlan extends ActiveRecord
{
    public function getCourseAmount()
    {
        /** @var StudyPlan $studyPlan */
        $studyPlan = StudyPlan::model()->findByAttributes(array(
            'speciality_id' => $this->speciality_id));
        if ($studyPlan) {
            return count($studyPlan->graph);
        } else {
            return 0;
        }
    }

    /** Допустима різниця між годинами в навчальному та робочому плані */
    const HOURS_DIFF = 5;
    public $plan_origin;
    public $work_origin;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'wp_plan';
    }

    /**
     * Group subject by cycles
     * @param $course
     * @return array
     */
    public function getSubjectsByCycles($course)
    {
        $list = array();
        foreach ($this->subjects as $item) {
            if ($item->presentIn($course)){
                $cycle = $item->subject->getCycle($this->speciality_id);
                $name = $cycle->id .' '. $cycle->title;
                if (isset($list[$name])) {
                    $list[$name][] = $item;
                } else {
                    $list[$name] = array($item);
                }
            }
        }
        return $list;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getList($id)
    {
        if (isset($id)) {
            /** @var Department $department */
            $department = Department::model()->findByAttributes(array('head_id' => $id));
            if (isset($department)) {
                $list = array();
                foreach ($department->specialities as $speciality) {
                    $list[$speciality->title] = CHtml::listData($speciality->studyPlans, 'id', 'title');
                }
                return $list;
            }
            return array();
        } else {
            return CHtml::listData(self::model()->findAll(), 'id', 'title');
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'subjects' => array(self::HAS_MANY, 'WorkSubject', 'plan_id'),
            'speciality' => array(self::BELONGS_TO, 'Speciality', 'speciality_id'),
            'year' => array(self::BELONGS_TO, 'StudyYear', 'year_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'year_id' => Yii::t('terms', 'Study year'),
            'speciality_id' => Yii::t('terms', 'Speciality'),
            'created' => Yii::t('terms', 'Date of creation'),
            'updated' => Yii::t('terms', 'Date of update'),
            'plan_origin' => 'Навчальний план для основи',
            'work_origin' => 'Робочий план для основи',
        );
    }

    public function rules()
    {
        return array(
            array('speciality_id, year_id', 'required'),
            array(
                'semesters',
                'required',
                'message' => 'Натисніть кнопку "Генерувати" та перевірте правильність даних',
                'on' => 'graph',
            ),
            array('speciality_id, year_id', 'uniqueRecord', 'on' => 'insert'),
            array('speciality_id', 'numerical', 'integerOnly' => true),
            array('created', 'default', 'value' => date('Y-m-d', time()), 'on' => 'insert'),
            array('id, speciality_id', 'safe', 'on' => 'search'),
            array('plan_origin, work_origin', 'check_origin', 'on' => 'insert'),
        );
    }

    public function uniqueRecord()
    {
        if (!$this->hasErrors()) {
            $record = self::model()->find('(speciality_id =:speciality_id) AND ( year_id = :year_id)',
                array(':speciality_id' => $this->speciality_id, ':year_id' => $this->year_id));
            if (isset($record)) {
                $this->addError('year_id', 'Для даного навчального року вже створений робочий план');
            }
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->speciality->title . ' - ' . $this->year->title;
    }

    public function check_origin()
    {
        if (!$this->hasErrors()) {
            if (empty($this->plan_origin) && (empty($this->work_origin))) {
                $this->addError('plan_origin, work_origin', 'Вкажіть план основу');
            }
        }
    }

    public function behaviors()
    {
        return array(
            'JSONBehavior' => array(
                'class' => 'application.behaviors.JSONBehavior',
                'fields' => array(
                    'graph'
                ),
            ),
            'StrBehavior' => array(
                'class' => 'application.behaviors.StrBehavior',
                'fields' => array(
                    'semesters',
                ),
            ),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
        );
    }

    /**
     * @return array
     */
    public function checkSubjects()
    {
        $warnings = array();
        foreach ($this->subjects as $subject) {
            if (abs(array_sum($subject->total) - (isset($subject->control_hours['total'])?$subject->control_hours['total']:0)) > self::HOURS_DIFF) {
                if (isset($subject->subject))
                    $warnings[] = 'Предмет "' . $subject->subject->title . '" за загальною кількістю годин відрізняється від навчального плану більше ніж на ' . self::HOURS_DIFF . ' годин';
            }
        }
        return implode(CHtml::tag('br'), $warnings);
    }

    protected function afterSave()
    {
        if (!empty($this->work_origin)) {
            $this->copyWorkPlan(WorkPlan::model()->findByPk($this->work_origin));
            $this->work_origin = null;
            $this->setIsNewRecord(false);
            $this->save(false);
        } elseif (!empty($this->plan_origin)) {
            $this->copyFromStudyPlan(StudyPlan::model()->findByPk($this->plan_origin));
            $this->plan_origin = null;
            $this->setIsNewRecord(false);
            $this->save(false);
        }
    }

    /**
     * Копіює предмети з плану-основи
     * @param WorkPlan $origin
     */
    protected function copyWorkPlan($origin)
    {
        $this->graph = $origin->graph;
        foreach ($origin->subjects as $subject) {
            $model = new WorkSubject();
            $model->attributes = $subject->attributes;
            $model->plan_id = $this->id;
            $model->save(false);
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StudyPlan the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param StudyPlan $origin
     */
    protected function copyFromStudyPlan(StudyPlan $origin)
    {
        $groups = $this->speciality->getGroupsByStudyYear($this->year_id);
        $graph = array();
        foreach ($groups as $course) {
            if (isset($origin->graph[$course - 1])) {
                $graph[] = $origin->graph[$course - 1];
            }
        }
        $this->graph = $graph;
        foreach ($origin->subjects as $subject) {
            $model = new WorkSubject();
            $model->plan_id = $this->id;
            $model->subject_id = $subject->subject_id;
            $model->dual_labs = $subject->dual_labs;
            $model->dual_practice = $subject->dual_practice;
            $control_hours = array();
            $control_hours['total'] = $subject->total;
            $control_hours['lectures'] = $subject->lectures;
            $control_hours['labs'] = $subject->labs;
            $control_hours['practs'] = $subject->practs;
            $model->control_hours = $control_hours;
            $model->weeks = $subject->weeks;
            $model->control = $subject->control;
            $model->save();
        }
    }

    protected function beforeSave()
    {
        if ($this->getScenario() == 'graph') {
            if (count($this->semesters) < 8) throw new CException("Немає відповідних груп для плану");
        }
        return parent::beforeSave();
    }


}