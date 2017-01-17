<?php

namespace app\modules\plans\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\plans\models\StudySubject;

/**
 * StudySubjectSearch represents the model behind the search form of `app\modules\plans\models\StudySubject`.
 */
class StudySubjectSearch extends StudySubject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'plan_id', 'subject_id', 'total', 'lectures', 'lab_works', 'practices', 'practice_weeks', 'dual_lab_work', 'dual_practice'], 'integer'],
            [['weeks', 'control', 'certificate_name', 'diploma_name'], 'safe'],
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
        $query = StudySubject::find();

        // add conditions that should always apply here

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
            'plan_id' => $this->plan_id,
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
            ->andFilterWhere(['like', 'certificate_name', $this->certificate_name])
            ->andFilterWhere(['like', 'diploma_name', $this->diploma_name]);

        return $dataProvider;
    }
}
