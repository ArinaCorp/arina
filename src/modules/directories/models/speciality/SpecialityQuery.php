<?php

namespace app\modules\directories\models\speciality;

/**
 * This is the ActiveQuery class for [[Speciality]].
 *
 * @see Speciality
 */
class SpecialityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Speciality[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Speciality|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
