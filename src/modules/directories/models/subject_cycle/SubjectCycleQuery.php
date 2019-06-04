<?php

namespace app\modules\directories\models\subject_cycle;


use nullref\useful\traits\MappableQuery;
use yii\db\ActiveQuery;

class SubjectCycleQuery extends ActiveQuery
{
    use MappableQuery;

    /**
     * @param SubjectCycle $model
     * @return $this
     */
    public function siblings(SubjectCycle $model)
    {
        return $this->byParent($model->parent_id)->without($model->id);
    }

    /**
     * @param $id
     * @return $this
     */
    public function without($id)
    {
        return $this->andWhere(['not', ['id' => $id]]);
    }

    /**
     * @param $id
     * @return $this
     */
    public function byParent($id)
    {
        return $this->andWhere(['parent_id' => $id]);
    }
}