<?php

namespace app\modules\accounting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\accounting\models\AccountingMounth;

/**
 * AccountingMounthSearch represents the model behind the search form of `app\modules\accounting\models\AccountingMounth`.
 */
class AccountingMounthSearch extends AccountingMounth
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'subject_id', 'teacher_id', 'date', 'hours'], 'integer'],
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
        $query = AccountingMounth::find();

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
            'group_id' => $this->group_id,
            'subject_id' => $this->subject_id,
            'teacher_id' => $this->teacher_id,
            'date' => $this->date,
            'hours' => $this->hours,
        ]);

        return $dataProvider;
    }
}
