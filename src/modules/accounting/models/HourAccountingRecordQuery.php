<?php

namespace app\modules\accounting\models;

/**
 * This is the ActiveQuery class for [[HourAccountingRecord]].
 *
 * @see HourAccountingRecord
 */
class HourAccountingRecordQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return HourAccountingRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return HourAccountingRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
