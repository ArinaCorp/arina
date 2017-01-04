<?php

namespace app\modules\employee\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EmployeeSearch represents the model behind the search form of `app\modules\students\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'cyclic_commission_id'], 'integer'],

            [['last_name', 'first_name', 'middle_name', 'position_id', 'is_in_education',
                'gender','passport','type', 'birth_date','cyclic_commission_id', 'passport', 'passport_issued_by'], 'safe'],
            [['passport', 'id'], 'unique'],
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
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Employee::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_in_education' => $this->is_in_education,
            'position_id' => $this->position_id,
            'category_id' => $this->category_id,
            'type' => $this->type,
            'gender' => $this->gender,
            'cyclic_commission_id' => $this->cyclic_commission_id,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'birth_date', $this->birth_date])
            ->andFilterWhere(['like', 'passport', $this->passport])
            ->andFilterWhere(['like', 'passport_issued_by', $this->passport_issued_by]);
        return $dataProvider;
    }
}
