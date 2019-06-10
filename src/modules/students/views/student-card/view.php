<?php

use app\modules\directories\models\subject\Subject;
use app\modules\journal\models\record\JournalMark;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View
 * @var $model \app\modules\students\models\StudentCard
 */

$this->title = Yii::t('app', 'Student card');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Study forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="subject-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= Html::a(Yii::t('app', 'Export'), ['student-card/export', 'student_id' => $model->studentId, 'study_year_id' => $model->studyYearId], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="table-bordered p1 hidden">
        <h3>Debug</h3>
        <?= 'Student id = ' . $model->studentId ?>
        <br>
        <?= 'Study year id = ' . $model->studyYearId ?>

        <?php foreach ($model->marks as $mark): ?>
            <h5><?= "Student: $mark->student_id Value: $mark->value Ticket: $mark->ticket Date: $mark->date Type: " . $mark->journalRecord->type ?></h5>
        <?php endforeach; ?>
        <h4><?= "Count: " . count($model->marks) ?></h4>
    </div>

    <div class="row clearfix">
        <!-- TODO: Make a foreach output for this bitch, looks creepy tbh -->

        <div class="col-lg-8">
            <div class="clearfix">
                <h4 class="pull-left"><?= Yii::t('app', 'Department') ?>:</h4>
                <h4 class="pull-left fw-normal mx-1"><?= $model->student->department->title ?></h4>
            </div>

            <div class="clearfix">
                <h4 class="pull-left"><?= Yii::t('app', 'Speciality Qualification ID') ?>:</h4>
                <h4 class="pull-left fw-normal mx-1"><?= $model->student->specialityQualification->title ?></h4>
            </div>

            <div class="clearfix">
                <h4 class="pull-left"><?= Yii::t('app', 'Speciality') ?>:</h4>
                <h4 class="pull-left fw-normal mx-1"><?= $model->student->speciality->title //TODO: speciality number (?)                         ?></h4>
            </div>
        </div>

        <div class="pull-right">
            <img class="" height="120px" width="120px">
        </div>

    </div>

    <hr>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Second name, first name, middle name') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= $model->student->fullName ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Birth Day') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= $model->student->birth_day ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Citizenship') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= 'Україна' //TODO: Implement citizenship / Probably take country_id as citizenship                        ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Finished') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= 'Заклад №0 ?-? ступенів м.Міста в 0000 році' //TODO: Implement prev. finished institution (?)                        ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Family status') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= 'Неодружений(на)' //TODO: Implement family status (?)                        ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Living address') //TODO: Implement address                       ?>
                :</h4>
            <h4 class="pull-left fw-normal mx-1"><?= 'Хмельницька обл., м.Хмельницький, Пр.Миру, 92/1, кв.22, тел. матері 097-261-56-75, тел. батька 068-712-87-53, тел.студ._096-692-88-70' ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Birth Day') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= $model->student->birth_day ?></h4>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Exemption presence upon entering') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= ' ? ' //TODO: Discuss wut is dis                       ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Enrolled by edict since') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= '11.08.2015 року №22 (?)' //TODO: Discuss implementation                       ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'By competition') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= 'зі стажем/без стажу (?)' //TODO: Discuss wtf is dis too                       ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Transferred in order from') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= ' ? ' //TODO: Discuss                       ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h5 class="pull-left"><?= Yii::t('app', 'By direction') ?>:</h5>
            <h5 class="pull-left fw-normal mx-1"><?= ' ? ' //TODO: Discuss                       ?></h5>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h5 class="pull-left"><?= Yii::t('app', 'By special conditions of partaking in the competition') ?>
                :</h5>
            <h5 class="pull-left fw-normal mx-1"><?= ' ? ' //TODO: Discuss                       ?></h5>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h5 class="pull-left"><?= Yii::t('app', 'Without competition') ?>:</h5>
            <h5 class="pull-left fw-normal mx-1"><?= ' ? ' //TODO: Discuss                       ?></h5>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h5 class="pull-left"><?= Yii::t('app', 'On conditions of absolute refund') ?>:</h5>
            <h5 class="pull-left fw-normal mx-1"><?= ' ? ' //TODO: Discuss                       ?></h5>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h5 class="pull-left"><?= Yii::t('app', 'By direction') ?>:</h5>
            <h5 class="pull-left fw-normal mx-1"><?= ' ? ' //TODO: Discuss                       ?></h5>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Employment history') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= ' ? ' //TODO: Discuss                       ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= 'Довге речення з реєстраційним номером D' ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= ' ? ' //TODO: Discuss                       ?></h4>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-12">
            <h4><?= Yii::t('app', 'Transition from course to course, a break from academic study, rewards and punishments') ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 table-bordered" style="height: 300px">
            <h3 class="alert alert-danger">Тут має бути таблиця з наказами</h3>
        </div>
    </div>
</div>

<div class="p2">
    <?php Pjax::begin();

    $items[] = [
        'label' => Yii::t('app', 'First') . ' ' . Yii::t('app', 'course'),
        'active' => true,
        'content' => $this->render('_course', ['model' => $model, 'course' => 1], true),
    ];

    $courseDict = [
        '1' => 'First',
        '2' => 'Second',
        '3' => 'Third',
        '4' => 'Fourth',
    ];

    for ($course = 2; $course <= $model->student->getCourse(); $course++) {
        $items[] = [
            'label' => Yii::t('app', $courseDict[$course]) . ' ' . Yii::t('app', 'course'),
            'content' => $this->render('_course', ['model' => $model, 'course' => $course], true),
        ];
    }

    ?>

    <?= Tabs::widget([
        'items' => $items,
    ]);
    ?>

    <?php Pjax::end(); ?>
</div>


