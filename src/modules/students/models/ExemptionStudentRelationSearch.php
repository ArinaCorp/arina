<?php

namespace app\modules\students\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\students\models\ExemptionStudentRelation;

/**
 * ExemptionStudentRelationSearch represents the model behind the search form about `\app\modules\students\models\ExemptionStudentRelation`.
 */
class ExemptionStudentRelationSearch extends ExemptionStudentRelation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'exemption_id', 'created_at', 'updated_at'], 'integer'],
            [['date_start', 'date_end', 'information'], 'safe'],
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
        $query = ExemptionStudentRelation::find();

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
            'student_id' => $this->student_id,
            'exemption_id' => $this->exemption_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ]);

        $query->andFilterWhere(['like', 'information', $this->information]);

        return $dataProvider;
    }
}
