<?php
/* @author VasyaKog */

namespace app\modules\students\models;

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
    public function rules()
    {
        return [
            [['id', 'sseed_id', 'user_id', 'gender', 'status', 'created_at', 'updated_at'], 'integer'],
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

        // add conditions that should always apply here
        $query->orderBy(['last_name' => SORT_ASC, 'first_name' => SORT_ASC, 'middle_name' => SORT_ASC]);
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
            'id' => $this->id,
            'sseed_id' => $this->sseed_id,
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'birth_day' => $this->birth_day,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'student_code', $this->student_code])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'passport_code', $this->passport_code])
            ->andFilterWhere(['like', 'tax_id', $this->tax_id]);

        return $dataProvider;
    }
}
