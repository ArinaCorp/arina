<?php

namespace app\modules\directories\models\audience;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Audience]].
 *
 * @see Audience
 */
class AudienceQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Audience[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Audience|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
