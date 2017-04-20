<?php

namespace app\modules\plans\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class WorkPlanSearch extends WorkPlan
{
    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return parent::rules();
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WorkPlan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'speciality_qualification_id' => $this->speciality_qualification_id,
            'created' => $this->created,
            'updated' => $this->updated,
            'study_year_id' => $this->study_year_id,
        ]);

        $query->andFilterWhere(['like', 'semesters', $this->semesters])
            ->andFilterWhere(['like', 'graph', $this->graph]);
        return $dataProvider;
    }
}
