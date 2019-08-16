<?php
/* @var $this yii\web\View */

$this->title = 'Update event user category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Event user category', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="programs-update">

    <?= $this->render("_form", [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
