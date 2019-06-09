<?php

use yii\helpers\Html;
use app\modules\directories\assets\SubjectCycleTreeAsset;
use yii\web\View;
/**
 * @var $this View
 * @var $id integer
 * @var $formName string
 * @var $subjectCycles \app\modules\directories\models\subject_cycle\SubjectCycle[]
 */
$this->registerJs("var selectedCategoryId = $id;", View::POS_BEGIN);
SubjectCycleTreeAsset::register($this);

$this->title = Yii::t('app', 'Subject cycles');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>
    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="tree" id="treeView" data-form-name="<?= $formName ?>">
        <?php if (count($subjectCycles)): ?>
            <ol class="category-list">
                <?php foreach ($subjectCycles as $subjectCycle): ?>
                    <?= $this->render('_item', [
                        'category' => $subjectCycle
                    ]) ?>
                <?php endforeach; ?>
            </ol>
        <?php endif ?>
    </div>
</div>
