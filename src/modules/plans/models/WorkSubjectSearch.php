<?php

namespace app\modules\plans\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class WorkSubjectSearch extends WorkSubject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        parent::rules();
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
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
            'work_plan_id' => $this->work_plan_id,
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
