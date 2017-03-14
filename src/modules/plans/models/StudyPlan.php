<?php

namespace app\modules\plans\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use nullref\useful\behaviors\JsonBehavior;
use yii\behaviors\TimestampBehavior;
use app\behaviors\StrBehavior;

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
 * @property array $graph
 * @property integer $created
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property StudySubject[] $studySubjects
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
            'JsonBehavior' => [
                'class' => JsonBehavior::className(),
                'fields' => ['graph'],
            ],
            'StrBehavior' => [
                'class' => StrBehavior::className(),
                'fields' => ['semesters'],
            ],
            'TimestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
            ]
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
            [['speciality_id'], 'required'],
            [['semesters'], 'required', 'message' => Yii::t('plans', 'Click "Generate" and check the data')],
            [['id', 'speciality_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['id', 'speciality_id'], 'safe', 'on' => 'search'],
            [['id'], 'unique']
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public static function getList($id = NULL)
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
        $usedSubjects = ArrayHelper::map(StudySubject::find()->all(), 'subject_id', 'id');
        $allSubjects = Subject::getListForSpeciality($this->speciality_id);
        $result = [];
        foreach ($allSubjects as $cycle => $subject) {
            $result[$cycle] = [];
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
    public function getStudySubjects()
    {
        return $this->hasMany(StudySubject::className(), ['study_plan_id' => 'id']);
    }

    /**
     * Group subject by cycles
     * @return array
     */
    public function getSubjectsByCycles()
    {
        $list = [];
        foreach ($this->studySubjects as $item) {
            $cycle = $item->subject->getCycle($this->speciality_id);
            $name = $cycle->id .' '. $cycle->title;
            if (isset($list[$name])) {
                $list[$name][] = $item;
            } else {
                $list[$name] = [$item];
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
            'id' => Yii::t('app', 'ID'),
            'speciality_id' => Yii::t('app', 'Speciality'),
            'semesters' => Yii::t('plans', 'Semesters'),
            'graph' => Yii::t('plans', 'Graph'),
            'created' => Yii::t('app', 'Date of creation'),
            'updated' => Yii::t('app', 'Date of update'),
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
            ->andFilterWhere(['like', 'graph', $this->graph]);
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function getStudyPlanStudySubjectProvider()
    {
        $query = StudySubject::find()->where(['study_plan_id' => $this->id]);

        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $provider;
    }

    /**
     * Get full title with update datetime
     * @return string
     */
    public function getTitle()
    {
        return $this->speciality->title . ' - ' . date('d.m.Y H:i', $this->created);
    }

    /**
     * @return false|string
     */
    public function getUpdatedForm() {
        return date('d.m.Y H:i', $this->updated);
    }
}
