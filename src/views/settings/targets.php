<?php

use yii\helpers\Url;
use testAsk\logManager\models\TargetCategoriesModel;

/* @var $this yii\web\View */

$this->title = 'Targets';
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="site-index">
    <div class="box box-primary">
        <div class="box-header">
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <table class="table table-striped table-bordered table-hover kv-grid-table kv-table-wrap">
                <thead>

                <tr>
                    <th>Name</th>
                    <th>Categories</th>
                    <th>Enabled</th>
                    <th>Params</th>
                    <th>Actions</th>
                </tr>

                </thead>
                <tbody>

                <?php foreach ($targetSettings as $class => $targetSetting) : ?>
                    <tr class="">
                        <td class="info" colspan="5"><?= $class ?>
                        </td>
                    </tr>
                    <?php foreach ($targetSetting as $target) : ?>
                        <tr data-key="1">
                            <td><?= $target['name'] ?></td>
                            <td><?= implode(', ', TargetCategoriesModel::getCategories($target['id'])) ?></td>
                            <td><?= $target['enabled'] ?></td>
                            <td><?= $target['params'] ?></td>
                            <td><a class="btn btn-default" href="<?= Url::to(['target-update', 'id' => $target['id']]) ?>" title="Edit"><i
                                            class="fa fa-fw fa-pencil"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4"></td>
                        <td style="text-align:right"><a class="btn btn-primary"
                                                        href="<?= Url::to(['target-create', 'class' => $class]) ?>">Add</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    </div>
</div>