<?php

namespace app\modules\students\controllers;

use app\modules\rbac\filters\AccessControl;
use app\modules\students\models\Student;
use app\modules\students\models\StudentCard;
use app\modules\user\models\User;
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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view','export'],
                        'roles' => [User::ROLE_STUDENT],
                    ],
                ]
            ]
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
            return $this->redirect(['student-card/view', 'student_id' => $model->studentId]);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Generate and view the student card.
     * @param $student_id
     * @return string
     */
    public function actionView($student_id)
    {
        $model = Student::findOne($student_id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Export the generated card.
     * @param $student_id
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function actionExport($student_id)
    {
        $model = new StudentCard(['studentId' => $student_id]);
        $model->getDocument();
    }
}
