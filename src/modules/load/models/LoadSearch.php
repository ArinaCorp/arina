<?php

namespace app\modules\load\models;

use yii\data\ActiveDataProvider;

class LoadSearch extends Load
{
    public $commission_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['commission_id', 'employee_id'], 'safe'],
        ];
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Load::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'study_year_id' => $this->study_year_id,
            'employee_id' => $this->employee_id,
            'group_id' => $this->group_id,
            'work_subject_id' => $this->work_subject_id,
            'type' => $this->type,
            'course' => $this->course,
        ]);

        $query->andFilterWhere(['like', 'consult', $this->consult])
            ->andFilterWhere(['like', 'students', $this->students])
            ->andFilterWhere(['like', 'fall_hours', $this->fall_hours])
            ->andFilterWhere(['like', 'spring_hours', $this->spring_hours]);

        return $dataProvider;
    }
}
