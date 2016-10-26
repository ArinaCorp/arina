<?php

namespace app\modules\directories\models\department;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DepartmentQuery represents the model behind the search form of `app\modules\department\models\Department`.
 */
class DepartmentQuery extends Department
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'head_id'], 'integer'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Department::find();

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
            'head_id' => $this->head_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
