<?php

namespace app\modules\plans\controllers;

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\plans\models\StudyPlanSearch;
use app\modules\rbac\filters\AccessControl;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use nullref\core\interfaces\IAdminController;
use yii\helpers\Url;
use yii\helpers\Json;
use app\components\DepDropHelper;

use app\modules\plans\models\StudyPlan;
use app\modules\plans\models\StudySubject;

class StudyPlanController extends Controller implements IAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => ['head-of-department', 'head-of-cyclic-commission'],
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StudyPlanSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = StudyPlan::find();

        if (!Yii::$app->user->isGuest) {
            /** @var User $user */
            $user = Yii::$app->user->identity;

            if (UserHelper::hasRole($user, 'head-of-department')) {
                if ($user->employee && $user->employee->department) {
                    $spQIds = SpecialityQualification::find()
                        ->andWhere([
                            'speciality_id' => $user->employee->department->getSpecialities()
                                ->select('id')
                                ->column(),
                        ])
                        ->select('id')
                        ->column();
                    $query->andWhere(['speciality_qualification_id' => $spQIds]);
                }
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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

        if ($model->load(Yii::$app->request->post())) {
            $model->attributes = $_POST['StudyPlan'];
            $model->created = time();

            if (isset(Yii::$app->session['weeks'])) {
                $model->semesters = Yii::$app->session['weeks'];
                unset(Yii::$app->session['weeks']);
            }

            if (isset(Yii::$app->session['graph'])) {
                $model->graph = Yii::$app->session['graph'];
                unset(Yii::$app->session['graph']);
            }

            if ($model->save()) {
                if (!empty($_POST['origin'])) {
                    $this->copyPlan(StudyPlan::findOne(['id' => $_POST['origin']]), $model);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * @param StudyPlan $origin
     * @param StudyPlan $newPlan
     */
    public function copyPlan($origin, $newPlan)
    {
        foreach ($origin->studySubjects as $subject) {
            $model = new StudySubject();
            $model->attributes = $subject->attributes;
            $model->study_plan_id = $newPlan->id;
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
        return $this->renderPartial('semesters_plan', ['data' => $semesters]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionCreateSubject($id)
    {
        $model = new StudySubject();
        $model->study_plan_id = $id;

        if (isset($_POST['StudySubject'])) {
            $model->attributes = $_POST['StudySubject'];
            if ($model->save()) {
                return $this->redirect(Url::toRoute(['study-plan/view', 'id' => $id]));
            }
        }
        return $this->render('create_subject', ['model' => $model]);
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

        if (isset($_POST['StudyPlan'])) {
            $model->attributes = $_POST['StudyPlan'];
            if (isset(Yii::$app->session['weeks'])) {
                $model->semesters = Yii::$app->session['weeks'];
                unset(Yii::$app->session['weeks']);
            }
            if (isset(Yii::$app->session['graph'])) {
                $model->graph = Yii::$app->session['graph'];
                unset(Yii::$app->session['graph']);
            }
            if ($model->save()) {
                return $this->render('view', ['model' => $model]);
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionUpdateSubject($id)
    {
        /** @var StudySubject $model */
        $model = StudySubject::findOne($id);

        if (isset($_POST['StudySubject'])) {
            $model->setAttributes($_POST['StudySubject'], false);
            if ($model->save()) {
                return $this->redirect(Url::toRoute(['study-plan/view', 'id' => $model->study_plan_id]));
            }
        }

        return $this->render('update_subject', ['model' => $model]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDeleteSubject($id)
    {
        $subject = StudySubject::findOne($id);
        $planId = $subject->study_plan_id;
        $subject->delete();
        return $this->redirect(Url::toRoute(['study-plan/view', 'id' => $planId]));
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

    /**
     * @param $id integer
     */
    public function actionExport($id)
    {
        /**
         * @var $model StudyPlan
         */
        $model = $this->findModel($id);
        $model->getDocument();
    }

    function actionGetOrigins()
    {
        $out = [];
        if (!empty($_POST['depdrop_all_params'])) {
            $params = $_POST['depdrop_all_params'];
            $spec = $params['studyplan-speciality_qualification_id'];
            DepDropHelper::convertMap(ArrayHelper::map(StudyPlan::find()->where([
                'speciality_qualification_id' => $spec,
            ])->all(), 'id', 'title'));
        }
        echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select ...')]);
        return;
    }

    public function actionResetGraph()
    {
        unset(Yii::$app->session['weeks']);
        unset(Yii::$app->session['graph']);
    }

}