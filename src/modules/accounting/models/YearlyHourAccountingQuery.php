<?php

namespace app\modules\accounting\models;

/**
 * This is the ActiveQuery class for [[YearlyHourAccounting]].
 *
 * @see YearlyHourAccounting
 */
class YearlyHourAccountingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return YearlyHourAccounting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return YearlyHourAccounting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
