<?php

namespace app\modules\plans\widgets;

use Yii;
use yii\bootstrap\Widget;
use yii\base\Exception;

use app\helpers\GlobalHelper;
use app\modules\directories\models\speciality\Speciality;
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
    /** @var $specialityId int for work plan */
    public $specialityId;
    /** @var $studyYearId int for work plan */
    public $studyYearId;
    public $studyPlanProcessLink = '/study-plan/execute-graph';
    public $workPlanProcessLink = '/work-plan/execute-graph';

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
                throw new Exception('Years amount must be set');

            for ($i = 0; $i < $this->yearAmount; $i++) {
                $this->rows[$i+1] = $i + 1;
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

            if (empty($this->specialityId))
                throw new Exception(Yii::t('plans', 'Speciality Id must be set'));

            if (empty($this->studyYearId))
                throw new Exception(Yii::t('plans', 'Study year Id must be set'));

            /** @var Speciality $speciality */
            $speciality = Speciality::findOne($this->specialityId);
            $this->rows = $speciality->getGroupsByStudyYear($this->studyYearId);

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