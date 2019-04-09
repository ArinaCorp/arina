<?php
/* @author VasyaKog */

namespace app\modules\students\models;

use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\user\helpers\UserHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\students\models\Student;

/**
 * StudentSearch represents the model behind the search form of `app\modules\students\models\Student`.
 */
class StudentSearch extends Student
{
    /**
     * @inheritdoc
     */
    public $group;
    public $exemptions;
    public $excluded;
    public $released;
    public $academic;
    public $payment;
    public $state_payment;
    public $active;
    public $renewal;
    public $speciality;
    public $department;

    public function rules()
    {
        return [
            [['id', 'state_payment', 'sseed_id', 'user_id', 'gender', 'status', 'created_at', 'updated_at'], 'integer'],
            [['last_name', 'first_name', 'middle_name'], 'string'],
            [['group','speciality','department'], 'integer'],
            ['exemptions', 'each', 'rule' => ['integer']],
            [['excluded', 'released', 'renewal', 'active', 'academic', 'payment'], 'boolean'],
            [['student_code', 'last_name', 'first_name', 'middle_name', 'birth_day', 'passport_code', 'tax_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Student::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
        ]);

        $query->andFilterWhere(['like', 'student_code', $this->student_code])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'passport_code', $this->passport_code])
            ->andFilterWhere(['like', 'tax_id', $this->tax_id]);


        if (!empty($this->group)) {
            $query->andWhere(['id' => StudentsHistory::getActiveStudentsIdsByGroups($this->group)]);
        }
        if (!empty($this->speciality)) {
            $query->andWhere(['id' => StudentFilter::getStudentIdsBySpecialityId($this->speciality)]);
        }
        if (!empty($this->department)) {
            $query->andWhere(['id' => StudentFilter::getStudentIdsByDepartmentId($this->department)]);
        }

        if (!empty($this->exemptions)) {
            $query->andWhere(['id' => StudentFilter::getStudentsByExemptionArray($this->exemptions)]);
        }

        if ($this->payment) {
            if ($this->state_payment == 1) {
                $query->andWhere(['id' => StudentFilter::getStateStudentIds()]);
            } else if ($this->state_payment == 0) {
                $query->andWhere(['id' => StudentFilter::getContractStudentIds()]);
            }
        }

        if ($this->released) {
            $query->andWhere(['id' => StudentFilter::getAllAlumnusStudentIds()]);
        }
        if ($this->active) {
            $query->andWhere(['id' => StudentFilter::getAllActiveStudentIds()]);
        }
        if ($this->renewal) {
            $query->andWhere(['id' => StudentFilter::getAllRenewalStudentIds()]);
        }
        return $dataProvider;
    }
}
