<?php

namespace app\modules\plans\widgets;

use Yii;
use yii\base\Exception;
use yii\bootstrap\Widget;

class SubjectTable extends Widget
{
    public $subjectDataProvider;

    public function init()
    {
        if ($this->subjectDataProvider === null)
            throw new Exception(Yii::t('plans', 'Property subjectDataProvider should be specified'), 1);
    }

    public function run()
    {

        return $this->render('subject_table', ['dataProvider' => $this->subjectDataProvider]);
    }
} 