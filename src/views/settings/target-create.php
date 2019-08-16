<?php
/* @var $this yii\web\View */

$this->title = 'Create target: ' . $model->class;
$this->params['breadcrumbs'][] = ['label' => 'Target', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="programs-update">

    <?= $this->render("_form", [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
