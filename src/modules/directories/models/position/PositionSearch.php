<?php

namespace app\modules\directories\models\position;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PositionSearch represents the model behind the search form about `app\modules\directories\models\position\Position`.
 */

class PositionSearch extends Position
{

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['id', 'max_hours_1', 'max_hours_2'], 'integer'],
            [['title'], 'safe'],
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
        $query = Position::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
