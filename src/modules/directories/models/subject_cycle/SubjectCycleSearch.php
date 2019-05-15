<?php

namespace app\modules\directories\models\subject_cycle;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SubjectCycleSearch
 * @package app\modules\directories\models\subject_cycle
 */
class SubjectCycleSearch extends SubjectCycle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'parent_id', 'evaluation_system_id'], 'safe'],
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
        $query = SubjectCycle::find();

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
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
