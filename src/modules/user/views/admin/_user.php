<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var yii\widgets\ActiveForm $form
 * @var \app\modules\user\models\User $user
 */

use app\modules\employee\models\Employee;
use app\modules\students\models\Student;
use kartik\select2\Select2;

?>

<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'password')->passwordInput() ?>
<?= $form->field($user, 'employee_id')->widget(Select2::class, [
    'data' => Employee::getMap('fullName', 'id', [], false),
    'options' => [
        'placeholder' => Yii::t('app', 'Select'),
    ]]); ?>
<?= $form->field($user, 'student_id')->widget(Select2::class, [
    'data' => Student::getMap('fullName', 'id', [], false),
    'options' => [
        'placeholder' => Yii::t('app', 'Select'),
    ]]); ?>

