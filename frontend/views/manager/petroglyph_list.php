<?php

/* @var $this yii\web\View */
/* @var $model Petroglyph */

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Petroglyph;

$this->title = Yii::t('manager', 'Petroglyph');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="text-right">
    <?= Html::a(Yii::t('manager', 'Add'), ['manager/petroglyph-create'], ['class' => 'btn btn-primary'])?>
</div>

<br>

<div class="clearfix"></div>

<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'id',
        'name',
        'lat',
        'lng',
        [
            'attribute' => 'culture_id',
            'format' => 'text',
            'value' => function ($model) {
                return isset($model->culture) ? $model->culture->name : null;
            }
        ],
        [
            'attribute' => 'epoch_id',
            'format' => 'text',
            'value' => function ($model) {
                return isset($model->epoch) ? $model->epoch->name : null;
            }
        ],
        [
            'attribute' => 'method_id',
            'format' => 'text',
            'value' => function ($model) {
                return isset($model->method) ? $model->method->name : null;
            }
        ],
        [
            'attribute' => 'style_id',
            'format' => 'text',
            'value' => function ($model) {
                return isset($model->style) ? $model->style->name : null;
            }
        ],
        [
            'attribute' => 'public',
            'format' => 'text',
            'value' => function ($model) {
                return $model->public ? Yii::t('manager', 'Public') : Yii::t('manager', 'Hide');
            }
        ],
        [
            'attribute' => 'image',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->image) ? null : Html::img(Petroglyph::SRC_IMAGE . '/' .  $model->thumbnailImage, ['width' => 100]);
            }
        ],
        [
            'attribute' => 'im_dstretch',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->im_dstretch) ? null : Html::img(Petroglyph::SRC_IMAGE . '/' .  $model->thumbnailImDstretch, ['width' => 100]);
            }
        ],
        [
            'attribute' => 'im_drawing',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->im_drawing) ? null : Html::img(Petroglyph::SRC_IMAGE . '/' .  $model->thumbnailImDrawing, ['width' => 100]);
            }
        ],
        [
            'attribute' => 'im_reconstruction',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->im_reconstruction) ? null : Html::img(Petroglyph::SRC_IMAGE . '/' .  $model->thumbnailImReconstr, ['width' => 100]);
            }
        ],
        [
            'attribute' => 'im_overlay',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->im_overlay) ? null : Html::img(Petroglyph::SRC_IMAGE . '/' .  $model->thumbnailImOverlay, ['width' => 100]);
            }
        ],
        [
            'class' => 'backend\grid\ActionColumn',
            'options' => ['style' => 'width: 100px;'],
            'buttons' => [
                'view' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-eye"></span>',
                        ['manager/petroglyph-view', 'id' => $model->id]);
                },
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-edit"></span>',
                        ['manager/petroglyph-update', 'id' => $model->id]);
                },
                'delete' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-trash"></span>',
                        ['manager/petroglyph-delete', 'id' => $model->id],
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
