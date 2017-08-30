<?php

namespace app\modules\accounting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\accounting\models\AccountingYear;

/**
 * AccountingYearSearch represents the model behind the search form of `app\modules\accounting\models\AccountingYear`.
 */
class AccountingYearSearch extends AccountingYear
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'teacher_id', 'subject_id','mounth'], 'integer'],
            [['mounth'], 'safe'],
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
        $query = AccountingYear::find();

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
            'teacher_id' => $this->teacher_id,
            'subject_id' => $this->subject_id,
            'mounth' => $this->mounth,
        ]);

        $query->andFilterWhere(['like', 'mounth', $this->mounth]);

        return $dataProvider;
    }
}
