<?php

namespace app\modules\plans\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

use app\modules\plans\models\WorkPlan;
use app\modules\plans\models\WorkSubject;

class WorkController extends Controller
{
    public $name = 'Work plan';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionCreate()
    {
        $model = new WorkPlan();

        $model->attributes = $_POST['WorkPlan'];
        $model->created = date('Y-m-d', time());

        if ($model->save()) {
            $this->redirect(Url::to('graph', ['id' => $model->id]));
        }
        $this->render('create', ['model' => $model]);
    }

    /**
     * @var WorkPlan $model
     * @param integer $id
     */
    public function actionGraph($id)
    {
        $model = WorkPlan::findOne($id);

        if (isset($_POST['yt0'])) {
            if (isset(Yii::$app->session['weeks'])) {
                $model->semesters = Yii::$app->session['weeks'];
                unset(Yii::$app->session['weeks']);
            }
            if (isset(Yii::$app->session['graph'])) {
                $model->graphs = Yii::$app->session['graph'];
                unset(Yii::$app->session['graph']);
            }
            if ($model->save()) {
                $this->redirect(Url::to('subjects', ['id' => $model->id]));
            }
        }
        $this->render('graph', ['model' => $model]);
    }

    /**
     * @param integer $id
     */
    public function actionView($id)
    {
        $model = WorkPlan::findOne($id);
        $this->render('view', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = WorkPlan::findOne($id);

        if (isset($_POST['WorkPlan'])) {
            $model->attributes = $_POST['WorkPlan'];
            if (isset(Yii::$app->session['weeks'])) {
                $model->semesters = Yii::$app->session['weeks'];
                unset(Yii::$app->session['weeks']);
            }
            if (isset(Yii::$app->session['graph'])) {
                $model->graph = Yii::$app->session['graph'];
                unset(Yii::$app->session['graph']);
            }
            if ($model->save()) {
                $this->redirect(['index']);
            }
        }

        $this->render('update', ['model' => $model]);

    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    //CRUD for Work Subject
    public function actionSubjects($id)
    {
        $model = WorkPlan::findOne($id);
        $this->render('subjects', ['model' => $model]);
    }

    public function actionAddSubject($id)
    {
        $model = new WorkSubject();
        $model->work_plan_id = $id;

        if (isset($_POST['WorkSubject'])) {
            $model->attributes = $_POST['WorkSubject'];
            if ($model->save())
                $this->redirect(Url::to('subjects', ['id' => $id]));
        }

        $this->render('subject_form', ['model' => $model, 'plan' => WorkPlan::findOne($id)]);
    }

    public function actionEditSubject($id)
    {
        /**
         * @var WorkSubject $model
         */
        $model = $this->findModel($id);

        if (isset($_POST['WorkSubject'])) {
            $model->attributes = $_POST['WorkSubject'];
            if ($model->save()) {
                $this->redirect(Url::to('view', ['id' => $model->work_plan_id]));
            }
        }

        $this->render('subject_form', ['model' => $model, 'plan' => $model->work_plan]);
    }

    public function actionDeleteSubject($id)
    {
        WorkSubject::findOne($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionExecuteGraph()
    {
        $semesters = [];
        $groups = [];
        if (isset($_POST['graph']) && isset($_POST['groups'])) {
            $groups = $_POST['groups'];
            $g = $_POST['graph'];
            foreach ($g as $i => $v) {
                $findFirst = false;
                $findSecond = false;
                $counter = 0;
                foreach ($v as $j) {
                    if ($j == 'T') {
                        $counter++;
                    }
                    if ($j == ' ') {
                        break;
                    }
                    if (($j != 'T') && ($j != 'P') && (!$findFirst)) {
                        $findFirst = true;
                        $semesters[$i + 1][1] = $counter;
                        $counter = 0;
                    } elseif (($j == 'T') && ($findFirst)) {
                        $findSecond = true;
                    } elseif (($j != 'T') && ($j != 'P') && ($findSecond)) {
                        $semesters[$i + 1][2] = $counter;
                        break;
                    }
                }
            }
        }
        $weeks = [];
        $last = 0;
        $lastYear = [];
        $errors = [];
        $semestersForGroups = [];
        foreach ($groups as $course => $subGroups) {
            foreach ($subGroups as $groupId => $groupName) {
                if (!empty($lastYear) && ($course == $last)) {
                    $t = $semesters[$groupId + 1];
                    if (($t[2] != $lastYear[2]) || ($t[1] != $lastYear[1])) {
                        $errors[$groupName] = "Кількість тижнів для груп на одному курсі різна (група $groupName)";
                    }
                }
                $semestersForGroups[$groupName] = $semesters[$groupId + 1];
                if ($course <> $last) {
                    $last = $course;
                    foreach ($semesters[$groupId + 1] as $semester) {
                        $weeks[] = $semester;
                    }
                    $lastYear = $semesters[$groupId + 1];
                }
            }
        }
        Yii::$app->session['weeks'] = $weeks;
        Yii::$app->session['graph'] = $_POST['graph'];
        $this->renderPartial('semestersPlan', ['data' => $semestersForGroups, 'errors' => $errors]);
    }

    /**
     * @param $id
     * @return WorkPlan
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = WorkPlan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('plans', 'The requested page does not exist'));
        }
    }

}