<?php

namespace app\modules\students\controllers;

/* @author VasyaKog */

use app\components\DepDropHelper;
use app\components\exporters\ExportFilteredstudents;
use app\components\ExportToExcel;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\rbac\filters\AccessControl;
use app\modules\students\models\Exemption;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use app\modules\students\models\StudentFilter;
use app\modules\students\models\StudentSearch;
use app\modules\students\models\StudentsHistory;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\debug\components\search\Filter;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `students` module
 */
class DefaultController extends Controller implements IAdminController
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
                        'roles' => ['head-of-department', 'staff-office'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public static function actionSpecialityList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $dep_id = $params["department-id"];

                    $out = DepDropHelper::convertMap(StudentFilter::getSpecialitiesByDepartmentId($dep_id));
                    if (empty($dep_id)) {
                        $out = DepDropHelper::convertMap(Group::getAllGroupsList());
                    }
                    return ['output' => $out, 'selected' => ''];
                }
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public static function actionGroupList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $spec_id = $params["spec-id"];
                    $dep_id = $params["department-id"];
                    $out = DepDropHelper::convertMap(StudentFilter::getGroupsListBySpecialityId($spec_id, $dep_id));
                    if (empty($spec_id)) {
                        $out = DepDropHelper::convertMap(Group::getAllGroupsList());
                    }
                    return ['output' => $out, 'selected' => ''];
                }
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionFilter()
    {
        $search = new StudentSearch();
//        var_dump(Yii::$app->request->queryParams);
        $student = $search->search(Yii::$app->request->queryParams);
        $group = new Group();
        $exemption = new Exemption();
        return $this->render('filter', [
            'student' => $student,
            'group' => $group,
            'exemption' => $exemption,
            'search' => $search,
            'aliasName' => $this
        ]);
    }

    /**
     * Displays a single Student model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Student();

        $default = Yii::$app->request->isPost ? [
            'FamilyRelation' => [],
            'StudentsPhone' => [],
            'StudentsEmail' => [],
            'StudentSocialNetwork' => [],
        ] : [];
        if ($model->loadWithRelations(array_merge($default, Yii::$app->request->post()))
            && $model->validateWithRelations()
            && $model->save(false)) {
            if (!Yii::$app->request->post('stay')) {
                return $this->redirect(['/students/default']);
            } else {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Student record is saved!'));
                return $this->redirect(['/students/default/update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'activeTab' => (int)Yii::$app->request->post('activeTab', 0),
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $default = Yii::$app->request->isPost ? [
            'FamilyRelation' => [],
            'StudentsPhone' => [],
            'StudentsEmail' => [],
            'StudentSocialNetwork' => [],
        ] : [];
        if ($model->loadWithRelations(array_merge($default, Yii::$app->request->post()))
            && $model->validateWithRelations()
            && $model->save(false)) {
            if (!Yii::$app->request->post('stay')) {
                return $this->redirect(['/students/default']);
            } else {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Student record is saved!'));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'activeTab' => (int)Yii::$app->request->post('activeTab', 0),
        ]);
    }


    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTest($id)
    {
        $model = $this->findModel($id);

        echo '<pre>';
        print_r($model->emails);
    }

    public function actionDocument(array $params)
    {

        $search = new StudentSearch();
        $students = null;
        $parameters = null;
        $model = [];
        $model['student_id'] = NULL;
        /* submit with links*/
        if (isset($params["student_id"])) {
            $parameters = $params["search"]["StudentSearch"];
            $students = $search->search($params["search"]);
            $model['student_id'] = $params["student_id"];
            array_push($model, ['student_id' => $params["student_id"]]);
        } else {
            $students = $search->search($params["search"]);
            if (isset($params['search']["StudentSearch"])) {
                $parameters = $params['search']["StudentSearch"];
            }
        }
        $model['students'] = $students;
        $model['parameters'] = $parameters;
        ExportToExcel::getDocument('filteredStudents', $model);
    }
}
