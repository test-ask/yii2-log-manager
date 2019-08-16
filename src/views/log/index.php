<?php

use yii\grid\GridView;
use testAsk\logManager\components\Logger;
use yii\helpers\Html;

$this->title = 'Log list';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-index">
    <div class="box box-primary">
        <div class="box-header">
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">

            <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'attribute' => 'level',
                            'content' => function ($model) {
                                return Logger::$levels[$model['level']];
                            },
                            'filter' => Logger::$levels,
                        ],
                        'created_at',
                        'updated_at',
                        'message',
                        'count',
                        [
                            'attribute' => 'is_resolved',
                            'content' => function ($model) {
                                return $model['is_resolved'] ? 'Resolved' : 'Not resolved';
                            },
                            'filter' => [
                                'Not resolved',
                                'Resolved',
                            ],
                        ],
                        [
                            'attribute' => 'resolve_user_id',
                            'content' => function ($model) use ($userSearch) {
                                if ($model['resolve_user_id']) {
                                    $user = $userSearch->getUserById($model['resolve_user_id']);
                                    return $user['name'];
                                }
                            },
                        ],
                        [
                            'attribute' => 'resolve_date',
                            'content' => function ($model) {
                                return $model['resolve_date'] ?? $model['resolve_date'];
                            },
                        ],
                        [
                            'header' => 'Actions',
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '<div class="btn-group"> {resolve}</div>',
                            'buttons' => [
                                'resolve' => function ($url, $model, $key) {
                                    return $model['is_resolved'] ? '' : Html::a('Resolve', \yii\helpers\Url::to(['resolve', 'id' => $model['id']]));
                                },
                            ]
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>
</div>
