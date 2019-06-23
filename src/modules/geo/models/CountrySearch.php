<?php
/* @author VasyaKog */

namespace app\modules\geo\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Search model for Country
 */
class CountrySearch extends Country
{

    public function rules()
    {
        return [
            [['code', 'name_en'], 'string']
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
        $query = Country::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'code',
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
        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name_en', $this->name_en]);


        return $dataProvider;
    }
}
