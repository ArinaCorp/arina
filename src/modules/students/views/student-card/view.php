<?php

use app\helpers\GlobalHelper;
use app\modules\directories\models\subject\Subject;
use app\modules\journal\models\record\JournalMark;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View
 * @var $model \app\modules\students\models\Student
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
            <?= Html::a(Yii::t('app', 'Export'), ['/students/student-card/export', 'student_id' => $model->id], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="table-bordered p1 hidden">
        <h3>Debug</h3>
        <?= 'Student id = ' . $model->id ?>
        <br>

        <?php foreach ($model->finalMarks as $mark): ?>
            <h5><?= "Student: $mark->student_id Value: $mark->value Ticket: $mark->ticket Date: $mark->date Type: " . $mark->journalRecord->type ?></h5>
        <?php endforeach; ?>
        <h4><?= "Count: " . count($model->finalMarks) ?></h4>
    </div>

    <div class="row clearfix">
        <!-- TODO: Make a foreach output for this bitch, looks creepy tbh -->

        <div class="col-lg-8">
            <div class="clearfix">
                <h4 class="pull-left"><?= Yii::t('app', 'Department') ?>:</h4>
                <h4 class="pull-left fw-normal mx-1"><?= $model->department->title ?></h4>
            </div>

            <div class="clearfix">
                <h4 class="pull-left"><?= Yii::t('app', 'Speciality Qualification ID') ?>:</h4>
                <h4 class="pull-left fw-normal mx-1"><?= $model->specialityQualification->title ?></h4>
            </div>

            <div class="clearfix">
                <h4 class="pull-left"><?= Yii::t('app', 'Speciality') ?>:</h4>
                <h4 class="pull-left fw-normal mx-1"><?= $model->speciality->title //TODO: speciality number (?)                                                                          ?></h4>
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
            <h4 class="pull-left fw-normal mx-1"><?= $model->fullName ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Birth Day') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= $model->birth_day ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Citizenship') ?>:</h4>
            <?php if($model->country): ?>
                <h4 class="pull-left fw-normal mx-1"><?= $model->country->name; ?></h4>
            <?php endif ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Finished') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= $model->finishedInstitution ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Family status') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= $model->familyStatus ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Living address') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= $model->livingAddress ?></h4>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Exemption presence upon entering') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= $model->fullExemptionString ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app', 'Enrolled by edict since') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= $model->enrollmentEdict->yearCmdString ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix hidden">
            <h5 class="pull-left"><?= Yii::t('app', 'By competition') ?>:</h5>
            <h5 class="pull-left fw-normal mx-1"><?= 'зі стажем/без стажу' ?></h5> <!-- TODO: Discuss -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h5 class="pull-left"><?= Yii::t('app', 'Transferred in order from') ?>:</h5>
            <h5 class="pull-left fw-normal mx-1"><?= $model->finished_inst ?></h5> <!-- TODO: Discuss -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix hidden">
            <h5 class="pull-left"><?= Yii::t('app', 'By direction') ?>:</h5>
            <h5 class="pull-left fw-normal mx-1"><?= 'Not used' ?></h5>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix hidden">
            <h5 class="pull-left"><?= Yii::t('app', 'By special conditions of partaking in the competition') ?>
                :</h5>
            <h5 class="pull-left fw-normal mx-1"><?= 'Not used' ?></h5>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h5 class="pull-left"><?= Yii::t('app', 'Without competition') ?>:</h5>
            <h5 class="pull-left fw-normal mx-1"><?= $model->withoutCompetition ? Yii::t('app', 'On exemption basis') : '' ?></h5>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix hidden">
            <h5 class="pull-left"><?= Yii::t('app', 'On conditions of absolute refund') ?>:</h5>
            <h5 class="pull-left fw-normal mx-1"><?= 'Discuss' ?></h5>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix hidden">
            <h4 class="pull-left"><?= Yii::t('app', 'Employment book') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= 'Not used' ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h4 class="pull-left"><?= Yii::t('app',
                    'Tax ID(or Passport Serial and Number)') ?>:</h4>
            <h4 class="pull-left fw-normal mx-1"><?= $model->tax_id ?></h4>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-12">
            <h4><?= Yii::t('app', 'Transition from course to course, a break from academic study, rewards and punishments') ?></h4>
        </div>
    </div>

    <div class="row">
        <table class="table table-bordered">
            <tr>
                <th><?= Yii::t('app', 'Course') ?></th>
                <th><?= Yii::t('app', 'Number and date of an edict') ?></th>
                <th><?= Yii::t('app', 'Content of an edict') ?></th>
            </tr>
            <?php if ($model->edicts):
                foreach ($model->edicts as $edict): ?>
                    <tr>
                        <td><?= $edict->course ?></td>
                        <td><?= $edict->cmdSinceString ?></td>
                        <td><?= $edict->content ?></td>
                    </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<div class="p2">
    <?php Pjax::begin();

    $items[] = [
        'label' => Yii::t('app', 'First') . ' ' . Yii::t('app', 'course'),
        'active' => true,
        'content' => $this->render('_course', ['model' => $model, 'course' => 1], true),
    ];

    // TODO: Implement a better way to get group's course, as at some point it will return >4. Define Max course for a group? Define finishing year?
    for ($course = 2; $course <= $model->course; $course++) {
        $items[] = [
            'label' => GlobalHelper::getOrderLiteral($course) . ' ' . Yii::t('app', 'course'),
            'content' => $this->render('_course', ['model' => $model, 'course' => $course], true),
        ];
    }

    ?>

    <?= Tabs::widget([
        'items' => $items,
    ]);
    ?>

    <?php Pjax::end(); ?>

    <?php
//    var_dump($model->currentGroup->title);
//    var_dump($model->currentGroup->getCourse($model->currentGroup->created_study_year_id+4));
//    die;
    ?>
</div>


