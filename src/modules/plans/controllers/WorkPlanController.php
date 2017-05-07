<?php

namespace app\modules\plans\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use nullref\core\interfaces\IAdminController;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use app\modules\plans\models\WorkPlan;
use app\modules\plans\models\WorkSubject;
use app\modules\plans\models\WorkPlanSearch;

class WorkPlanController extends Controller implements IAdminController
{
    public $name = 'Work plan';

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WorkPlanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new WorkPlan();

        if ($model->load(Yii::$app->request->post())) {
            $model->attributes = $_POST['WorkPlan'];
            $model->created = date('Y-m-d', time());

            if ($model->save()) {
                return $this->redirect(['graph', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string
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
                $model->graph = Yii::$app->session['graph'];
                unset(Yii::$app->session['graph']);
            }
            if ($model->save()) {
                return $this->redirect(Url::to('subjects', ['id' => $model->id]));
            }
        }
        return $this->render('graph', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = WorkPlan::findOne($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string
     */
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
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['model' => $model]);

    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionSubjects($id)
    {
        $model = WorkPlan::findOne($id);
        return $this->render('subjects', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionAddSubject($id)
    {
        $model = new WorkSubject();
        $model->work_plan_id = $id;

        if (isset($_POST['WorkSubject'])) {
            $model->attributes = $_POST['WorkSubject'];
            if ($model->save())
                return $this->redirect(Url::to('subjects', ['id' => $id]));
        }

        return $this->render('subject_form', ['model' => $model, 'plan' => WorkPlan::findOne($id)]);
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionEditSubject($id)
    {
        /**
         * @var WorkSubject $model
         */
        $model = $this->findModel($id);

        if (isset($_POST['WorkSubject'])) {
            $model->attributes = $_POST['WorkSubject'];
            if ($model->save()) {
                return $this->redirect(Url::to('view', ['id' => $model->work_plan_id]));
            }
        }

        return $this->render('subject_form', ['model' => $model, 'plan' => $model->work_plan]);
    }

    /**
     * @param $id
     * @return Response
     */
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
                        $errors[$groupName] = Yii::t('plans',
                                'Number of weeks is different for same groups of course (group') . $groupName .')';
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
        return $this->renderPartial('semestersPlan', ['data' => $semestersForGroups, 'errors' => $errors]);
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