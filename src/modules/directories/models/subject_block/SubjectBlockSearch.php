<?php

namespace app\modules\directories\models\subject_block;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SubjectBlockSearch represents the model behind the search form about `app\modules\directories\models\subject\Subject`.
 */
class SubjectBlockSearch extends SubjectBlock
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'practice'], 'integer'],
            [['title', 'short_name', 'code'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SubjectBlock::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'practice' => $this->practice,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'short_name', $this->short_name]);

        return $dataProvider;
    }
}
