<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 30.04.2019
 * Time: 12:38
 */

namespace app\modules\load\models;


use app\modules\plans\models\WorkPlan;
use nullref\useful\traits\MappableQuery;
use yii\db\ActiveQuery;

class LoadQuery extends ActiveQuery
{
    use MappableQuery;

    /**
     * @param $workPlanId
     * @param $groupId
     * @return LoadQuery
     */
    public function byWorkPlanForGroup($workPlanId, $groupId)
    {
        $workPlan = WorkPlan::findOne($workPlanId);
        $workSubjects = $workPlan->getWorkSubjects()
            ->select(['id'])
            ->column();

        return $this
            ->joinWith('workSubject')
            ->joinWith('workSubject.subject')
            ->joinWith('group')
            ->where([
                'group_id' => $groupId,
                'work_subject_id' => $workSubjects,
                'study_year_id' => $workPlan->study_year_id,
            ])
            ->andWhere(['not', ['employee_id' => null]]);
    }
}