<?php

namespace app\modules\plans\models\work_subject;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WorkSubjectSearch represents the model behind the search form of `app\modules\students\models\WorkSubject`.
 */
class WorkSubjectSearch extends WorkSubject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'plan_id', 'subject_id', 'cyclic_commission_id', 'project_hours'], 'integer'],
            [['total', 'lectures', 'labs', 'practices', 'weeks', 'control', 'certification_name',
                'diploma_name', 'control_hours', 'dual_labs', 'dual_practice'], 'safe'],
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
            'plan_id' => $this->plan_id,
            'subject_id' => $this->subject_id,
            'cyclic_commission_id' => $this->cyclic_commission_id,
            'project_hours' => $this->project_hours,
            'dual_labs' => $this->dual_labs,
            'dual_practice' => $this->dual_practice,
        ]);

        $query->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'lectures', $this->lectures])
            ->andFilterWhere(['like', 'labs', $this->labs])
            ->andFilterWhere(['like', 'practices', $this->practices])
            ->andFilterWhere(['like', 'weeks', $this->weeks])
            ->andFilterWhere(['like', 'control', $this->control])
            ->andFilterWhere(['like', 'certificate_name', $this->certificate_name])
            ->andFilterWhere(['like', 'diploma_name', $this->diploma_name])
            ->andFilterWhere(['like', 'control_hours', $this->control_hours]);
        return $dataProvider;
    }
}
