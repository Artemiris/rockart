<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Эпоха';
$this->params['breadcrumbs'] = [
    ['label' => 'Управление контентом', 'url' => ['/manager/index']],
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="text-right">
    <?= Html::a('Добавить', ['manager/epoch-create'], ['class' => 'btn btn-primary'])?>
</div>

<br>

<div class="clearfix"></div>

<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'name',
        [
            'class' => 'backend\grid\ActionColumn',
            'options' => ['style' => 'width: 100px;'],
            'buttons' => [
                'view' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-eye"></span>',
                        ['manager/epoch-view', 'id' => $model->id]);
                },
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-edit"></span>',
                        ['manager/epoch-update', 'id' => $model->id]);
                },
                'delete' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-trash"></span>',
                        ['manager/epoch-delete', 'id' => $model->id],
                        [
                            'data-pjax' => "0",
                            'data-confirm' => "Вы уверены, что хотите удалить этот элемент?",
                            'data-method' => "post"
                        ]);
                }
            ],
        ],
    ],
]) ?>
