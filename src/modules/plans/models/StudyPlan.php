<?php

namespace app\modules\plans\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\department\Department;
use app\modules\directories\models\subject\Subject;

/**
 * This is the model class for table "study_plan".
 *
 * The followings are the available columns in table 'study_plan':
 * @property integer $id
 * @property integer $speciality_id
 * @property array $semesters
 * @property array $graphs
 * @property integer $created
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property StudySubject[] $study_subjects
 * @property Speciality $speciality
 */
class StudyPlan extends ActiveRecord
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            /*'JSONBehavior' => [
                'class' => 'application.behaviors.JSONBehavior',
                'fields' => ['graphs'],
            ],
            'StrBehavior' => [
                'class' => 'application.behaviors.StrBehavior',
                'fields' => ['semesters'],
            ],
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ],*/
        ];
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
            /*[['speciality_id'], 'required'],
            [['semesters'], 'required', 'message' => Yii::t('plans', 'Click "Generate" and check the data')],
            [['speciality_id'], 'integer' => true],
            [['created'], 'default', 'value' => date('Y-m-d', time()), 'on' => 'insert'],
            [['id, speciality_id'], 'safe', 'on' => 'search'],*/
        ];
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

    /**
     * @return array
     */
    public function getUnusedSubjects()
    {
        $usedSubjects = ArrayHelper::map($this->study_subjects, 'subject_id', 'id');
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
     * @return ActiveQuery
     */
    public function getSpeciality()
    {
        return $this->hasOne(Speciality::className(), ['id' => 'speciality_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStudySubject()
    {
        return $this->hasMany(StudySubject::className(), ['speciality_id' => 'id']) ->via('study_subjects');
    }

    /**
     * Group subject by cycles
     * @return array
     */
    public function getSubjectsByCycles()
    {
        $list = array();
        foreach ($this->study_subjects as $item) {
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
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('App', 'ID'),
            'year_id' => Yii::t('plans', 'Study year'),
            'speciality_id' => Yii::t('plans', 'Speciality'),
            'semesters' => Yii::t('plans', 'Semesters'),
            'graphs' => Yii::t('plans', 'Graphs'),
            'created' => Yii::t('plans', 'Date of creation'),
            'updated' => Yii::t('plans', 'Date of update'),
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StudyPlan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'speciality_id' => $this->speciality_id,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'semesters', $this->semesters])
            ->andFilterWhere(['like', 'graphs', $this->graphs]);
        return $dataProvider;
    }

    /**
     * Get dataProvider for study plan subjects
     * @return ActiveRecord[]
     */
    public function getPlanSubjectProvider()
    {
        return StudySubject::find()->where(['plan_id' => 'id'])->all();
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
