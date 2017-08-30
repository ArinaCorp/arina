<?php

namespace app\modules\directories\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StudyYearSearch extends StudyYear
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['year_start', 'required'],
            [['year_start'], 'integer'],
            ['active', 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StudyYear::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'year_start' => $this->year_start,
            'active' => $this->active,
        ]);

        return $dataProvider;
    }
}
