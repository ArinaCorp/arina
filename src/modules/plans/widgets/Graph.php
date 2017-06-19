<?php

namespace app\modules\plans\widgets;

use Yii;
use yii\bootstrap\Widget;
use yii\base\Exception;

use app\helpers\GlobalHelper;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\helpers\PlanHelper;

class Graph extends Widget
{
    public $readOnly = false;
    public $model;
    public $field;
    public $graph = null;
    public $studyPlan = true;
    /** @var $yearAmount int for study plan */
    public $yearAmount = 4;
    /** @var $speciality_qualification_id int for work plan */
    public $speciality_qualification_id;
    /** @var $studyYearId int for work plan */
    public $study_year_id;
    public $studyPlanProcessLink = '/plans/study-plan/execute-graph';
    public $workPlanProcessLink = '/plans/work-plan/execute-graph';

    protected $list;
    protected $map;
    protected $graphProcessLink;
    protected $rows = [];

    public function init()
    {
        $this->list = GlobalHelper::getWeeksByMonths();
        if ($this->studyPlan) {
            $this->graphProcessLink = $this->studyPlanProcessLink;
            if (empty($this->yearAmount))
                throw new Exception(Yii::t('plans', 'Years amount must be set'));

            for ($i = 0; $i < $this->yearAmount; $i++) {
                $this->rows[$i + 1] = $i + 1;
            }

            if (isset($this->graph)) {
                $this->map = $this->graph;
            } else {
                $this->map = PlanHelper::getDefaultPlan();
            }
        }
        else
        {
            $this->graphProcessLink = $this->workPlanProcessLink;

            if (empty($this->speciality_qualification_id))
                throw new Exception(Yii::t('plans', 'Speciality Id must be set'));

            if (empty($this->study_year_id))
                throw new Exception(Yii::t('plans', 'Study year Id must be set'));

            /** @var SpecialityQualification $specialityQualification */
            $specialityQualification = SpecialityQualification::findOne($this->speciality_qualification_id);
            $this->rows = $specialityQualification->getGroupsByStudyYear($this->study_year_id);

            if (empty($this->graph)) {
                $this->map = PlanHelper::getDefaultWorkPlan($this->rows);
            } else {
                $this->map = $this->graph;
            }
        }
    }

    public function run()
    {
        return $this->render('graph', [
            'graphProcessLink' => $this->graphProcessLink,
            'map' => $this->map,
            'list' => $this->list,
            'rows' => $this->rows,
            'readOnly' => $this->readOnly
        ]);
    }
}