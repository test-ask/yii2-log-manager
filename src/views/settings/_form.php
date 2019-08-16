<?php

use app\assets\Select2Asset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $item \app\modules\user\models\User */

Select2Asset::register($this);

$categories = array_combine($categories, $categories);
?>

<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->errorSummary($model) ?>
        <?= $form->field($model, 'class')->hiddenInput()->label(false); ?>
        <div class="form-group">
            <?= $form->field($model, 'name')->textInput(); ?>
        </div>
        <?php foreach ($model->params as $key => $params) : ?>
            <div class="form-group">
                <?= $form->field($model, 'params[' . $key . ']')->textInput()->label(ucfirst($key)); ?>
            </div>
        <?php endforeach; ?>
        <div class="form-group">
            <?= $form->field($model, 'categories')->dropDownList($categories, ['multiple' => true, 'class' => 'form-control select2']); ?>
        </div>
        <div class="form-group col-sm-3">
            <?= $form->field($model, 'enabled')->checkbox(); ?>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
