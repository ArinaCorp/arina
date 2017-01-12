<?php

namespace app\modules\students\models;

use Yii;
use yii\db\ActiveRecord;
use app\modules\directories\models\speciality\Speciality;
use app\modules\plans\models\study_subject\StudySubject;

/**
 * This is the model class for table "sp_plan".
 *
 * The followings are the available columns in table 'sp_plan':
 * @property integer $id
 * @property integer $speciality_id
 * @property array $semesters
 * @property array $graph
 * @property integer $created
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property StudySubject[] $subjects
 * @property Speciality $speciality
 */
class StudyPlan extends ActiveRecord
{
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
     * @param $id
     * @return array
     */
    public static function getList($id)
    {
        if (isset($id)){
            /** @var Department $department */
            $department = Department::model()->findByAttributes(array('head_id'=>$id));
            if (isset($department)){
                $list = array();
                foreach($department->specialities as $speciality){
                    $list[$speciality->title] = CHtml::listData($speciality->studyPlans, 'id','title');
                }
                return $list;
            }
            return array();
        } else {
            return CHtml::listData(self::model()->findAll(),'id', 'title');
        }
    }

    public function getUnusedSubjects()
    {
        $usedSubjects = CHtml::listData($this->subjects, 'subject_id', 'id');
        $allSubjects = Subject::getListForSpeciality($this->speciality_id);
        $result = array();
        foreach ($allSubjects as $cycle => $subject) {
            $result[$cycle] = array();
            foreach ($subject as $id => $name) {
                if (!isset($usedSubjects[$id])) {
                    $result[$cycle][$id] = $name;
                }
            }
            if (empty($result[$cycle])) {
                unset($result[$cycle]);
            }
        }
        return $result;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sp_plan';
    }

    /**
     * @param null $config
     * @return CActiveDataProvider
     */
    public function getProvider($config = null)
    {
        if (Yii::app()->user->checkAccess('dephead') && !Yii::app()->user->checkAccess('admin')) {
            $headId = Yii::app()->getUser()->identityId;
            if ($config === null) {
                $config = array('criteria' => array());
            } elseif ($config['criteria'] === null) {
                $config['criteria'] = array();
            }
            $criteria = new CDbCriteria($config['criteria']);
            $criteria->with = array('speciality'=>array('with'=>array('department')));
            $criteria->addCondition('department.head_id = :head_id');
            $criteria->params[':head_id'] = $headId;
            $config['criteria'] = $criteria;
        }
        return parent::getProvider($config);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('speciality_id', 'required'),
            array('semesters', 'required', 'message' => 'Натисніть кнопку "Генерувати" та перевірте правильність даних'),
            array('speciality_id', 'numerical', 'integerOnly' => true),
            array('created', 'default', 'value' => date('Y-m-d', time()), 'on' => 'insert'),
            array('id, speciality_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'subjects' => array(self::HAS_MANY, 'StudySubject', 'plan_id'),
            'speciality' => array(self::BELONGS_TO, 'Speciality', 'speciality_id'),
        );
    }

    /**
     * Group subject by cycles
     * @return array
     */
    public function getSubjectsByCycles()
    {
        $list = array();
        foreach ($this->subjects as $item) {
            $cycle = $item->subject->getCycle($this->speciality_id);
            $name = $cycle->id .' '. $cycle->title;
            if (isset($list[$name])) {
                $list[$name][] = $item;
            } else {
                $list[$name] = array($item);
            }
        }
        return $list;
    }

    /**
     * @return array
     */
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
        $criteria->compare('speciality_id', $this->speciality_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Get dataProvider for study plan subjects
     * @return CActiveDataProvider
     */
    public function getPlanSubjectProvider()
    {
        return new CActiveDataProvider(StudySubject::model(), array(
            'criteria' => array(
                'condition' => 'plan_id = :plan_id',
                'params' => array(':plan_id' => $this->id),
            )
        ));
    }

    /**
     * Get full title with update datetime
     * @return string
     */
    public function getTitle()
    {
        return $this->speciality->title . ' - ' . date('H:i d.m.Y', $this->updated);
    }
}
