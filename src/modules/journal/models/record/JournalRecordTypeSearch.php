<?php

namespace app\modules\journal\models\record;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\journal\models\record\JournalRecordType;

/**
 * JournalRecordTypeSearch represents the model behind the search form about `app\modules\journal\models\record\JournalRecordType`.
 */
class JournalRecordTypeSearch extends JournalRecordType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'description', 'homework', 'hours', 'present', 'date', 'n_pp', 'n_in_day', 'ticket', 'is_report', 'report_title', 'work_type_id'], 'integer'],
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
        $query = JournalRecordType::find();

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
            'description' => $this->description,
            'homework' => $this->homework,
            'hours' => $this->hours,
            'present' => $this->present,
            'date' => $this->date,
            'n_pp' => $this->n_pp,
            'n_in_day' => $this->n_in_day,
            'ticket' => $this->ticket,
            'is_report' => $this->is_report,
            'report_title' => $this->report_title,
            'work_type_id' => $this->work_type_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
