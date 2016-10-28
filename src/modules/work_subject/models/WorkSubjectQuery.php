<?php

namespace app\modules\work_subject\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[WorkSubject]].
 *
 * @see WorkSubject
 */
class WorkSubjectQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return WorkSubject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WorkSubject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
