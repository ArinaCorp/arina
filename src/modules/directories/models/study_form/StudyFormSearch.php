<?php

namespace app\modules\directories\models\study_form;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StudyFormSearch represents the model behind the search form about `app\modules\directories\models\study_form\StudyForm`.
 */
class StudyFormSearch extends StudyForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StudyForm::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'title' => $this->title,
        ]);

        return $dataProvider;
    }
}
