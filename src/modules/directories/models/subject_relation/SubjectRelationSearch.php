<?php

namespace app\modules\directories\models\subject_relation;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SubjectRelationSearch
 * @package app\modules\directories\models\subject_relation
 */
class SubjectRelationSearch extends SubjectRelation
{
    public $subject;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'subject_id', 'speciality_qualification_id', 'subject_cycle_id'], 'integer'],
            [['subject'], 'safe'],
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

        $query->joinWith('subject');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['subject'] = [
            'asc' => ['subject.title' => SORT_ASC],
            'desc' => ['subject.title' => SORT_DESC]
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'subject_id' => $this->subject_id,
            'speciality_qualification_id' => $this->speciality_qualification_id,
            'subject_cycle_id' => $this->subject_cycle_id,
        ]);

        $query->andFilterWhere(['like', 'subject.title', $this->subject]);

        return $dataProvider;
    }
}
