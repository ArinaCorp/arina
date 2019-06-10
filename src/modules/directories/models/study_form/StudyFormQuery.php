<?php

namespace app\modules\directories\models\study_form;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[StudyForm]].
 *
 * @see StudyForm
 */
class StudyFormQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     * @return StudyForm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StudyForm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
