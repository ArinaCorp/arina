<?php

namespace app\modules\plans\models\study_plan;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use app\modules\directories\models\speciality\Speciality;
use app\modules\plans\models\study_subject\StudySubject;
use app\modules\directories\models\department\Department;
use app\modules\directories\models\subject\Subject;

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
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'subjects' => array(self::HAS_MANY, 'StudySubject', 'plan_id'),
            'speciality' => array(self::BELONGS_TO, 'Speciality', 'speciality_id'),
        );
    }

    public function getSpeciality()
    {
        return $this->hasOne(Speciality::className(), ['id' => 'speciality_id'])
    }

    /**
     * @param $id
     * @return array
     */
    public static function getList($id)
    {
        /** @var Department $department */
        if (isset($id)) {
            $department = Department::find()->where(['head_id'=>$id])->all();
            if (isset($department)) {
                $list = [];
                foreach($department->specialities as $speciality){
                    $list[$speciality->title] = ArrayHelper::map($speciality->studyPlans, 'id','title');
                }
                return $list;
            }
            return [];
        } else {
            return ArrayHelper::map(StudyPlan::find()->all(),'id', 'title');
        }
    }

    public function getUnusedSubjects()
    {
        $usedSubjects = ArrayHelper::map($this->subjects, 'subject_id', 'id');
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
    public static function tableName()
    {
        return '{{%study_plan}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['speciality_id', 'required'],
            ['semesters', 'required', 'message' => 'Натисніть кнопку "Генерувати" та перевірте правильність даних'],
            ['speciality_id', 'numerical', 'integerOnly' => true],
            ['created', 'default', 'value' => date('Y-m-d', time()), 'on' => 'insert'],
            ['id, speciality_id', 'safe', 'on' => 'search'],
        ];
    }

    //here

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
