<?php

namespace app\modules\students\controllers;

use app\modules\students\models\StudentCard;
use yii\web\Controller;

use nullref\core\interfaces\IAdminController;
use Yii;

class StudentCardController extends Controller implements IAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

        ];
    }

    /**
     * Index form.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new StudentCard();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['student-card/view', 'student_id' => $model->studentId, 'study_year_id' => $model->studyYearId]);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Generate and view the student card.
     * @param $student_id
     * @param $study_year_id
     * @return string
     */
    public function actionView($student_id, $study_year_id)
    {
        $model = new StudentCard(['studentId' => $student_id, 'studyYearId' => $study_year_id]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Export the generated card.
     * @param $student_id
     * @param $study_year_id
     */
    public function actionExport($student_id, $study_year_id)
    {
        $model = new StudentCard(['studentId' => $student_id, 'studyYearId' => $study_year_id]);
        $model->getDocument();
    }
}
