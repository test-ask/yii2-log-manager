<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use testAsk\logManager\models\UserCategoryModel;

$this->title = 'User categories';
$this->params['breadcrumbs'][] = ['label' => $this->title];

$categories = array_combine($categories, $categories);

//todo require
\app\assets\Select2Asset::register($this);
?>

<div class="site-index">

    <div class="box box-primary">
        <div class="box-header">
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered table-hover'
                ],
                'columns' => [
                    'id',
                    'name',
                    [
                        'label' => 'Category',
                        'content' => function ($model) use ($categories) {
                            return Html::dropDownList('userCategories', UserCategoryModel::getCategoriesByUserId($model['id']), $categories, [
                                'multiple' => true,
                                'class' => 'form-control select2',
                                'style' => 'width: 100%',
                                'data-user-id' => $model['id']
                            ]);
                        }
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>

<?php
$url = Url::to('user-categories-update');
$script = <<< JS
    $('select.select2').on('change', function(e) {
        var categories = $(this).val();
        var userId = $(this).data('user-id');
 
        $.post('{$url}', {
            categories: categories.length ? categories : [''],
            userId: userId,
        }, function(response) {
          if (response.status == 'error') {
              alert(response.errors);
          }
    })});
JS;
$this->registerJs($script);
?>
