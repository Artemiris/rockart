<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('manager', 'Culture');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="text-right">
    <?= Html::a(Yii::t('manager', 'Add'), ['manager/culture-create'], ['class' => 'btn btn-primary'])?>
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
                        ['manager/culture-view', 'id' => $model->id]);
                },
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-edit"></span>',
                        ['manager/culture-update', 'id' => $model->id]);
                },
                'delete' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-trash"></span>',
                        ['manager/culture-delete', 'id' => $model->id],
                        [
                            'data-pjax' => "0",
                            'data-confirm' => Yii::t('manager', 'Do you really want to delete?'),
                            'data-method' => "post"
                        ]);
                }
            ],
        ],
    ],
]) ?>
