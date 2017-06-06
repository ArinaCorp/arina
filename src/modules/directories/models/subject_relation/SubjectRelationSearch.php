<?php

namespace app\modules\directories\models\subject_relation;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SubjectRelationSearch
 * @package app\modules\directories\models\subject_relation
 */
class SubjectRelationSearch extends SubjectRelation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'subject_id', 'speciality_qualification_id', 'subject_cycle_id'], 'integer'],
            [['id', 'subject_id', 'speciality_qualification_id', 'subject_cycle_id'], 'safe'],
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
        $query = SubjectRelation::find();

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
            'subject_id' => $this->subject_id,
            'speciality_qualification_id' => $this->speciality_qualification_id,
            'subject_cycle_id' => $this->subject_cycle_id,
        ]);

        return $dataProvider;
    }
}
