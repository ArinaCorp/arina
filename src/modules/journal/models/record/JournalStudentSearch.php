<?php

namespace app\modules\journal\models\record;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\journal\models\record\JournalStudent;

/**
 * JournalStudentSearch represents the model behind the search form about `app\modules\journal\models\record\JournalStudent`.
 */
class JournalStudentSearch extends JournalStudent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'load_id', 'student_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
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
        $query = JournalStudent::find();

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
            'load_id' => $this->load_id,
            'student_id' => $this->student_id,
            'type' => $this->type,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
