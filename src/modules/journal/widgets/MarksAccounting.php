<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 30.04.2019
 * Time: 13:22
 */

namespace app\modules\journal\widgets;

use app\modules\journal\models\accounting\MarksAccountingForm;
use app\modules\load\models\Load;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class MarksAccounting extends Widget
{
    public $loads = [];
    public $load_id;
    public $students = [];
    public $records = [];

    public function run()
    {
        $model = new MarksAccountingForm([
            'load_id' => $this->load_id
        ]);

        if ($this->load_id || $model->load(Yii::$app->request->post())){
            $load = Load::findOne($model->load_id);
            $this->students = $load->group->getStudentsArray();
            $subject = $load->workSubject->subject;
            $this->records = $load->journalRecords;
        }

        return $this->render('marks_accounting', [
            'loads' => $this->loads,
            'load_id' => $this->load_id,
            'students' => $this->students,
            'dates' => $this->records,
            'model' => $model
        ]);
    }
}