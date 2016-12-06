<?php

namespace app\modules\employee\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Employee]].
 *
 * @see Employee
 */
class EmployeeQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Employee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Employee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
