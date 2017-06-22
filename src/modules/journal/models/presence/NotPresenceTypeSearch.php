<?php

namespace app\modules\journal\models\presence;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\journal\models\presence\NotPresenceType;

/**
 * NotPresenceTypeSearch represents the model behind the search form about `app\modules\journal\models\presence\NotPresenceType`.
 */
class NotPresenceTypeSearch extends NotPresenceType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_great', 'percent_hours', 'created_at', 'updated_at'], 'integer'],
            [['title', 'label'], 'safe'],
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
        $query = NotPresenceType::find();

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
            'is_great' => $this->is_great,
            'percent_hours' => $this->percent_hours,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'label', $this->label]);

        return $dataProvider;
    }
}
