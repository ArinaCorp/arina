<?php

namespace app\modules\plans\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class StudySubjectSearch extends StudySubject
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
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StudySubject::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'study_plan_id' => $this->study_plan_id,
            'subject_id' => $this->subject_id,
            'total' => $this->total,
            'lectures' => $this->lectures,
            'lab_works' => $this->lab_works,
            'practices' => $this->practices,
            'practice_weeks' => $this->practice_weeks,
            'dual_lab_work' => $this->dual_lab_work,
            'dual_practice' => $this->dual_practice,
        ]);

        $query->andFilterWhere(['like', 'weeks', $this->weeks])
            ->andFilterWhere(['like', 'control', $this->control])
            ->andFilterWhere(['like', 'diploma_name', $this->diploma_name])
            ->andFilterWhere(['like', 'certificate_name', $this->certificate_name]);
        return $dataProvider;
    }
}
