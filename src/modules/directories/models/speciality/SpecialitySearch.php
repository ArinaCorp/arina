<?php

namespace app\modules\directories\models\speciality;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\directories\models\speciality\Speciality;

/**
 * SpecialitySearch represents the model behind the search form of `app\modules\directories\models\Speciality`.
 */
class SpecialitySearch extends Speciality
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'department_id'], 'integer'],
            [['title', 'department', 'number', 'accreditation_date'], 'safe'],
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
        $query = Speciality::find();

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
            'department_id' => $this->department_id,
            'accreditation_date' => $this->accreditation_date,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'number', $this->number]);

        return $dataProvider;
    }
}
