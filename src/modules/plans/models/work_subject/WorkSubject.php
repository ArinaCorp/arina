<?php

namespace app\modules\plans\models\work_subject;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

use app\modules\directories\models\subject\Subject;
use app\modules\directories\models\cyclic_commission\CyclicCommission;
use app\modules\plans\models\work_plan\WorkPlan;
use app\modules\directories\models\StudyYear;

/**
 * This is the model class for table "work_subject".
 *
 * The followings are the available columns in table 'work_subject':
 * @property integer $id
 * @property integer $subject_id
 * @property integer $work_plan_id
 * @property array $total
 * @property array $lectures
 * @property array $lab_works
 * @property array $practices
 * @property array $weeks
 * @property array $control
 * @property integer $cyclic_commission_id
 * @property string $certificate_name
 * @property string $diploma_name
 * @property integer $project_hours
 * @property array $control_hours
 * @property bool $dual_lab_work
 * @property bool $dual_practice
 *
 * The followings are the available model relations:
 * @property WorkPlan $work_plan
 * @property Subject $subject
 * @property CyclicCommission $cycle_commission
 */
class WorkSubject extends ActiveRecord
{
    const CONTROL_TEST = 0;
    const CONTROL_EXAM = 1;
    const CONTROL_DPA = 2;
    const CONTROL_DA = 3;
    const CONTROL_WORK = 4;
    const CONTROL_PROJECT = 5;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'StrBehavior' => [
                    'class' => 'application.behaviors.StrBehavior',
                    'fields' => [
                        'total',
                        'lectures',
                        'lab_works',
                        'practices',
                        'weeks',
                    ]
                ],
                'JSONBehavior' => [
                    'class' => 'application.behaviors.JSONBehavior',
                    'fields' => [
                        'control',
                        'control_hours',
                    ]
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wp_subject}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'work_plan_id', 'subject_id', 'cyclic_commission_id', 'project_hours'], 'integer'],
            [['subject_id', 'dual_lab_work', 'dual_practice'], 'required'],
            [['total', 'lectures', 'lab_works', 'practices', 'weeks', 'control'], 'default', 'value' => ''],
            [['certificate_name', 'diploma_name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_plan_id' => Yii::t('Plans', 'Plan ID'),
            'subject_id' => Yii::t('Plans', 'Subject ID'),
            'total' => Yii::t('Plans', 'Total'),
            'lectures' => Yii::t('Plans', 'Lectures'),
            'lab_works' => Yii::t('Plans', 'Laboratory'),
            'practices' => Yii::t('Plans', 'Practices'),
            'weeks' => Yii::t('Plans', 'Weeks'),
            'control' => Yii::t('Plans', 'Control'),
            'cyclic_commission_id' => Yii::t('Plans', 'Cyclic Commission ID'),
            'certificate_name' => Yii::t('Plans', 'Certificate name'),
            'diploma_name' => Yii::t('Plans', 'Diploma name'),
            'project_hours' => Yii::t('Plans','Project hours'),
            'control_hours' => Yii::t('Plans', 'Control hours'),
            'dual_lab_work' => Yii::t('Plans', 'Dual laboratory works'),
            'dual_practice'=>Yii::t('Plans', 'Dual practice works'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCyclicCommission()
    {
        return $this->hasOne(CyclicCommission::className(), ['id' => 'cyclic_commission_id']);
    }

    /**
     * @param $semester
     * @return integer
     */
    public function getSelfWork($semester)
    {
        return $this->total[$semester] - $this->getClasses($semester);
    }

    /**
     * @param $semester
     * @return integer
     */
    public function getClasses($semester)
    {
        return $this->weeks[$semester] * $this->work_plan->semesters[$semester];
    }

    /**
     * @param $course
     * @return bool
     */
    public function presentIn($course)
    {
        $spring = $course * 2;
        $fall = $spring - 2;
        $spring--;
        return !empty($this->total[$fall]) ||
            !empty($this->weeks[$fall]) ||
            !empty($this->total[$spring]) ||
            !empty($this->weeks[$spring]);
    }

    /**
     * @return bool
     */
    public function hasProject()
    {
        for ($i = 0; $i < count($this->control); $i++)
            if ($this->control[$i][self::CONTROL_PROJECT] || $this->control[$i][self::CONTROL_WORK])
                return true;

        return false;
    }

    /**
     * @param $year
     * @param bool $onlyProjects
     * @return array
     */
    public static function getListByYear($year, $onlyProjects = false)
    {
        /**
         * @var StudyYear $model
         * @var WorkPlan $plan
         */
        $model = StudyYear::find()->where(['id' => $year])->one();
        $subjects = [];

        if ($onlyProjects) {
            foreach ($model->work_plans as $plan)
                foreach ($plan->work_subjects as $subject)
                    if ($subject->hasProject())
                        $subjects[] = $subject;
        } else {
            foreach ($model->work_plans as $plan)
                $subjects = array_merge($subjects, $plan->work_subjects);
        }
        return ArrayHelper::map($subjects, 'id', 'subject.title');
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WorkSubject::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'plan_id' => $this->work_plan_id,
            'subject_id' => $this->subject_id,
            'cyclic_commission_id' => $this->cyclic_commission_id,
            'project_hours' => $this->project_hours,
            'dual_lab_works' => $this->dual_lab_work,
            'dual_practice' => $this->dual_practice,
        ]);

        $query->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'lectures', $this->lectures])
            ->andFilterWhere(['like', 'lab_works', $this->lab_works])
            ->andFilterWhere(['like', 'practices', $this->practices])
            ->andFilterWhere(['like', 'weeks', $this->weeks])
            ->andFilterWhere(['like', 'control', $this->control])
            ->andFilterWhere(['like', 'certificate_name', $this->certificate_name])
            ->andFilterWhere(['like', 'diploma_name', $this->diploma_name])
            ->andFilterWhere(['like', 'control_hours', $this->control_hours]);
        return $dataProvider;
    }
}