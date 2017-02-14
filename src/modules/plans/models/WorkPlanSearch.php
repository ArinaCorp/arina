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
        return [
            /*['speciality_id, study_year_id', 'required'],
            [
                'semesters', 'required',
                'message' => Yii::t('plans', 'Click "Generate" and check the data'), 'on' => 'graphs'
            ],
            ['speciality_id', 'study_study_year_id', 'uniqueRecord', 'on' => 'insert'],
            ['speciality_id', 'numerical', 'integerOnly' => true],
            ['created', 'default', 'value' => date('Y-m-d', time()), 'on' => 'insert'],
            ['id', 'speciality_id', 'safe', 'on' => 'search'],
            ['study_plan_origin', 'work_plan_origin', 'check_origin', 'on' => 'insert'],*/
        ];
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

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'speciality_id' => $this->speciality_id,
            'created' => $this->created,
            'updated' => $this->updated,
            'study_year_id' => $this->study_year_id,
        ]);

        $query->andFilterWhere(['like', 'semesters', $this->semesters])
            ->andFilterWhere(['like', 'graphs', $this->graphs]);
        return $dataProvider;
    }
}
