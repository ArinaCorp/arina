<?php

namespace app\modules\directories\models\subject_block;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[SubjectBlock]].
 *
 * @see SubjectBlock
 */
class SubjectBlockQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     * @return SubjectBlock[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SubjectBlock|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
