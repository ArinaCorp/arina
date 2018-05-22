<?php

namespace app\modules\students\controllers;

/* @author VasyaKog */
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\rbac\filters\AccessControl;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use app\modules\students\models\StudentSearch;
use app\modules\students\models\StudentsHistory;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\data\ActiveDataProvider;
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


        $query = Group::find();

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
                    $query->andWhere(['speciality_qualifications_id' => $spQIds]);
                }
            }
        }

        $groupIds = $query->column();
        $students = Student::find()
            ->andWhere(['id' => StudentsHistory::getActiveStudentsIdsByGroups($groupIds)]);
        $dataProvider = new ActiveDataProvider([
            'query' => $students,
        ]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
}
