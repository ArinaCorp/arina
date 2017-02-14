<?php

namespace app\modules\plans\controllers;

use app\modules\plans\models\StudyPlanSearch;
use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use nullref\core\interfaces\IAdminController;
use yii\helpers\Url;

use app\modules\plans\models\StudyPlan;
use app\modules\plans\models\StudySubject;

class StudyPlanController extends Controller implements IAdminController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StudyPlanSearch();
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
        $model = new StudyPlan();
        $model->created = date('Y-m-d', time());

        if (isset(Yii::$app->session['weeks'])) {
            $model->semesters = Yii::$app->session['weeks'];
            unset(Yii::$app->session['weeks']);
        }

        if (isset(Yii::$app->session['graph'])) {
            $model->graphs = Yii::$app->session['graph'];
            unset(Yii::$app->session['graph']);
        }

        if ($model->save()) {
            if (!empty($_POST['origin'])) {
                $this->copyPlan(StudyPlan::findOne($_POST['origin']), $model);
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param StudyPlan $origin
     * @param StudyPlan $newPlan
     */
    public function copyPlan($origin, $newPlan)
    {
        foreach ($origin->study_subjects as $subject) {
            $model = new StudySubject();
            $model->attributes = $subject->attributes;
            $model->plan_id = $newPlan->id;
            $model->save(false);
        }
    }

    public function actionExecuteGraph()
    {
        $semesters = [];
        if (isset($_POST['graph'])) {
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
        foreach ($semesters as $course) {
            foreach ($course as $week) {
                $weeks[] = $week;
            }
        }
        Yii::$app->session['weeks'] = $weeks;
        Yii::$app->session['graph'] = $_POST['graph'];
        $this->renderPartial('semestersPlan', ['data' => $semesters]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionSubjects($id)
    {
        $model = new StudySubject();
        $model->plan_id = $id;

        if (isset($_POST['StudySubject'])) {
            $model->attributes = $_POST['StudySubject'];
            if ($model->save()) {
                $model = new StudySubject();
                $model->plan_id = $id;
            }
        }
        return $this->render('subjects', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = StudyPlan::findOne($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

    }

    /**
     * @param $id
     */
    public function actionEditSubject($id)
    {
        /** @var StudySubject $model */
        $model = StudySubject::findOne($id);

        if (isset($_POST['StudySubject'])) {
            $model->setAttributes($_POST['StudySubject'], false);
            if ($model->save()) {
                $this->redirect(Url::to('view', ['id' => $model->plan_id]));
            }
        }

        $this->render('edit_subject', ['model' => $model]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDeleteSubject($id)
    {
        StudySubject::findOne($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDelete($id)
    {
        StudyPlan::findOne($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return StudyPlan
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudyPlan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}