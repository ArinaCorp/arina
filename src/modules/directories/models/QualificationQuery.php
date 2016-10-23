<?php

namespace app\modules\directories\models;

/**
 * This is the ActiveQuery class for [[Qualification]].
 *
 * @see Qualification
 */
class QualificationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Qualification[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Qualification|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
