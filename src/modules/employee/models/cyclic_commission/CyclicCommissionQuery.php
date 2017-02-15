<?php

namespace app\modules\employee\models\cyclic_commission;

/**
 * This is the ActiveQuery class for [[CyclicCommission]].
 *
 * @see CyclicCommission
 */
class CyclicCommissionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CyclicCommission[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CyclicCommission|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
