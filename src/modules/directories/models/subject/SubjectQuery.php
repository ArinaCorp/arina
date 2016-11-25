<?php

namespace app\modules\directories\models\subject;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Subject]].
 *
 * @see Subject
 */
class SubjectQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     * @return Subject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Subject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
