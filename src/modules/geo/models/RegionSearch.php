<?php

namespace app\modules\geo\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Search model for Region
 */
class RegionSearch extends Region
{

    public function rules()
    {
        return [
            [['country_code', 'division_code', 'name_en'], 'string']
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
        $query = Region::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'country_code',
                    'division_code',
                    'name_en',
//                    'name' => [
//                        'asc' => ['name_en' => SORT_ASC],
//                        'desc' => ['name_en' => SORT_DESC],
//                    ],
                ],
                'defaultOrder' => [
//                    'name' => SORT_ASC,
                    'name_en' => SORT_ASC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'division_code', $this->division_code])
            ->andFilterWhere(['like', 'country_code', $this->country_code])
            ->andFilterWhere(['like', 'name_en', $this->name_en]);


        return $dataProvider;
    }
}
