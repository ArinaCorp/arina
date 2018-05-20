<?php

namespace app\modules\plans\controllers;

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\rbac\filters\AccessControl;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\Url;
use nullref\core\interfaces\IAdminController;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use app\modules\plans\models\WorkPlan;
use app\modules\plans\models\WorkSubject;
use app\modules\plans\models\StudyPlan;
use app\modules\plans\models\WorkPlanSearch;

class WorkPlanController extends Controller implements IAdminController
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
                        'roles' => ['head-of-department'],
                    ]
                ]
            ]
        ];
    }

    public $name = 'Work plan';

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WorkPlanSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = WorkPlan::find();

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
        $model = new WorkPlan();

        if ($model->load(Yii::$app->request->post())) {
            $model->attributes = $_POST['WorkPlan'];
            $model->created = time();

            $post = Yii::$app->request->post('WorkPlan');
            $model->study_plan_origin = $post['study_plan_origin'];
            $model->work_plan_origin = $post['work_plan_origin'];

            if ($model->save()) {
                $model->scenario = WorkPlan::SCENARIO_GRAPH;
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

        if (Yii::$app->request->post()) {
            if (isset(Yii::$app->session['weeks'])) {
                $model->semesters = Yii::$app->session['weeks'];
                unset(Yii::$app->session['weeks']);
            }
            if (isset(Yii::$app->session['graph'])) {
                $model->graph = Yii::$app->session['graph'];
                unset(Yii::$app->session['graph']);
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
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

        if (Yii::$app->request->post()) {
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
                return $this->redirect(['view', 'id' => $model->id]);
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
     */
    public function actionExport($id)
    {
        /**
         * @var $model WorkPlan
         */
        $model = $this->findModel($id);
        $model->getDocument();
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionUpdateSubject($id)
    {
        /** @var WorkSubject $model */
        $model = WorkSubject::findOne($id);

        if (Yii::$app->request->post()) {
            $model->attributes = $_POST['WorkSubject'];
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->work_plan_id]);
            }
        }

        return $this->render('update_subject', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionCreateSubject($id)
    {
        $model = new WorkSubject();
        $model->work_plan_id = $id;

        if (Yii::$app->request->post()) {
            $model->attributes = $_POST['WorkSubject'];
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->work_plan_id]);
        }

        return $this->render('create_subject', ['model' => $model]);
    }

    public function actionDeleteSubject($id)
    {
        $subject = WorkSubject::findOne($id);
        $planId = $subject->work_plan_id;
        $subject->delete();
        return $this->redirect(Url::toRoute(['work-plan/view', 'id' => $planId]));
    }

    /**
     * @return string
     */
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
        return $this->renderPartial('semesters_plan', ['data' => $semestersForGroups, 'errors' => $errors]);
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