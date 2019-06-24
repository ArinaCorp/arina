<?php

use app\modules\plans\models\StudentPlan;
use app\modules\students\models\Student;
use app\modules\user\models\User;
use yii\bootstrap\Tabs;
use yii\widgets\Pjax;

/** @var User $user */
$user = Yii::$app->user->identity;
$student = $user->student;
?>
<?= Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'Student plan'),
            'content' => $student->currentStudentPlan
                ? $this->render('@app/modules/plans/views/student-plan/view', ['model' => $student->currentStudentPlan])
                : $this->render('@app/modules/plans/views/student-plan/create', [
                    'model' => new StudentPlan([
                        'student_id' => $student->id,
                        'work_plan_id' => $student->currentWorkPlan->id,
                        'semester' => $student->currentSemester,
                    ]),
                    'formView' => '_student-form',
                ]),
            'active' => true,

        ],
        [
            'label' => Yii::t('app', 'Student card'),
            'content' => $this->render('@app/modules/students/views/student-card/view', [
                'model' => $student,
            ]),
        ],

    ],
    'itemOptions' => [
        'class' => 'p2',
    ],
    'encodeLabels' => false,
]) ?>
