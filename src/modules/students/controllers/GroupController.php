<?php

namespace app\modules\students\controllers;

use app\components\DepDropHelper;
use app\components\ExportHelpers;
use app\components\ExportToExcel;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\subject\Subject;
use app\modules\journal\models\record\JournalRecord;
use app\modules\journal\models\record\JournalRecordType;
use app\modules\load\models\Load;
use app\modules\plans\models\StudyPlan;
use app\modules\plans\models\StudySubject;
use app\modules\rbac\filters\AccessControl;
use app\modules\students\models\ExportParams;
use app\modules\students\models\Group;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller implements IAdminController
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
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'document'],
                        'roles' => ['teacher', 'curator'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $ids = [];

        $showAll = true;

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

                    $showAll = false;
                    $ids = array_merge($ids, Group::find()->andWhere(['speciality_qualifications_id' => $spQIds])->select('id')->column());
                }
            }

            if (UserHelper::hasRole($user, 'curator')) {
                if ($user->employee) {
                    $curatorGroupId = Group::find()->andWhere(['curator_id' => $user->employee->id])->select('id')->column();
                    $ids = array_merge($ids, $curatorGroupId);
                    $showAll = false;
                }
            }
        }


        $query = Group::find();

        if (!$showAll) {
            $ids = array_unique($ids);
            $query->andWhere(['id' => $ids]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
     * @param integer $id
     * @param ExportParams $exportParams
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $exportParams = new ExportParams();
        if (isset(Yii::$app->request->post()["ExportParams"])) {
            $exportParams->load(Yii::$app->request->post());
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->findModel($id)->getStudentsArray(),
        ]);
        $dataProvider->pagination->setPageSize(40);


        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
            'exportParams' => $exportParams
        ]);
    }

    /**
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Group();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
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
     * Deletes an existing Group model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionDocument($id)
    {
        $model = $this->findModel($id);
        $model->getDocument();
    }

    public function actionAttestation()
    {
        $data = (Yii::$app->request->post()["ExportParams"]);
        $model = [
            'data' => $data
        ];
        ExportToExcel::getDocument('Attestation', $model);
    }

    public function actionCredit()
    {
        $data = (Yii::$app->request->post()["ExportParams"]);
        $model = [
            'data' => $data
        ];
        ExportToExcel::getDocument('Credit', $model);
    }

    public function actionSemester()
    {
        $data = (Yii::$app->request->post()["ExportParams"]);
        $model = [
            'data' => $data
        ];
        ExportToExcel::getDocument('Semester', $model);
    }

    public function actionExam()
    {
        $data = (Yii::$app->request->post()["ExportParams"]);
        $model = [
            'data' => $data
        ];
        ExportToExcel::getDocument('Exam', $model);
    }


    public static function actionCreditSubjectList($group_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $semester = null;
                    $year_id = $params["years-id"];

                    $subjects = ExportHelpers::getSubjectsInLoadByGroupAndYear($group_id, $year_id);

                    $out = DepDropHelper::convertMap(ArrayHelper::map($subjects, 'id', 'title'));

                    if (empty($year_id)) {
                        $out = '';
                    }
                    return ['output' => $out, 'selected' => ''];
                }
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public static function actionJournalRecordList($group_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $semester = null;
                    $year_id = $params["years-id"];
                    $subject_id = $params["subject-id"];
                    $type_id = JournalRecordType::findOne(['title'=>'Залік'])->id;
                    $records = ExportHelpers::getRecordsInLoadBySubjectGroupAndType($group_id,$subject_id,$type_id);

                    $out = DepDropHelper::convertMap(ArrayHelper::map($records, 'id', 'date'));

                    if (empty($year_id)) {
                        $out = '';
                    }
                    return ['output' => $out, 'selected' => ''];
                }
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public static function actionSubjectList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $semester = null;
                    $dep_id = null;
                    if ($params["plan_id"]) {
                        $dep_id = $params["plan_id"];
                    }

                    $plan = StudyPlan::findOne(['id' => $dep_id]);
                    $subjects = $plan->studySubjects;
                    $subject_list = ArrayHelper::map($subjects, 'id', 'title');
                    $out = DepDropHelper::convertMap($subject_list);

                    if (!empty($params['ex-sem'])) {
                        $semester = $params["ex-sem"];

                        $subjects = array_filter($subjects, function ($sub) use ($semester) {
                            /** @var StudySubject $sub */
                            return $sub->control[$semester - 1][1] == true;
                        });
                        $out = DepDropHelper::convertMap(ArrayHelper::map($subjects, 'subject_id', 'title'));
                    }
                    if (!empty($params['cred-sem'])) {
                        $semester = $params["cred-sem"];
//                        $subjects = [];
//                        $allSubjects = Subject::find()
//                            ->joinWith('workSubject')
//                            ->leftJoin('load', 'load.work_subject_id = work_subject.id')
//                            ->leftJoin('journalRecords', 'journal_record.load_id == load.id')
//                            ->where(['load.group_id' => 5])
//                            ->all();
//                        foreach ($allSubjects as $subject) {
//                            $records = array_filter($subject->relatedRecords, function ($record)use($semester){
//                                return ExportHelpers::isRecordInSemester($record,$semester);
//                            });
//                            if(count($records)!=0)array_push($subjects,$subject);
//                        }
                        $subjects = array_filter($subjects, function ($sub) use ($semester) {
                            /** @var StudySubject $sub */
                            return $sub->control[$semester - 1][0] == true;
                        });
                        $out = DepDropHelper::convertMap(ArrayHelper::map($subjects, 'subject_id', 'title'));
                    }
                    if (empty($dep_id)) {
                        $out = '';
                    }
                    return ['output' => $out, 'selected' => ''];
                }
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
