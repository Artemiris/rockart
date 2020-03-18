<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model Petroglyph */
/* @var $providerComposition PetroglyphComposition[] */
/* @var $providerImage PetroglyphImage[] */
/* @var $providerThreeD PetroglyphThreeD[] */

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Petroglyph;
use common\models\Composition;
use common\models\PetroglyphImage;
use common\models\PetroglyphThreeD;
use yii\grid\GridView;

$name = 'name_' . Yii::$app->language;
$this->title = $model->$name;
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('manager', 'Petroglyph'), 'url' => ['/manager/petroglyph']],
    $this->title,
];
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="clearfix">
        <?= Html::a(Yii::t('manager', 'View'), ['petroglyph/view', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <div class="pull-right">
            <?= Html::a(Yii::t('manager', 'Edit'), ['manager/petroglyph-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php if (empty($model->deleted)): ?>
                <?= Html::a(Yii::t('manager', 'Delete'), ['manager/petroglyph-delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('manager', 'Do you really want to delete?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </div>

    </div>

    <br>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'name_en',
        'lat',
        'lng',
        'index',
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
            'attribute' => 'description',
            'format' => 'html',
        ],
        [
            'attribute' => 'description_en',
            'format' => 'html',
        ],
        [
            'attribute' => 'technical_description',
            'format' => 'html',
        ],
        [
            'attribute' => 'technical_description_en',
            'format' => 'html',
        ],
        [
            'attribute' => 'publication',
            'format' => 'html',
        ],
        [
            'attribute' => 'publication_en',
            'format' => 'html',
        ],
        [
            'attribute' => 'image',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->image) ? null : Html::img(Petroglyph::SRC_IMAGE . '/' . $model->thumbnailImage);
            }
        ],
        [
            'attribute' => 'im_dstretch',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->im_dstretch) ? null : Html::img(Petroglyph::SRC_IMAGE . '/' . $model->thumbnailImDstretch);
            }
        ],
        [
            'attribute' => 'im_drawing',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->im_drawing) ? null : Html::img(Petroglyph::SRC_IMAGE . '/' . $model->thumbnailImDrawing);
            }
        ],
        [
            'attribute' => 'im_reconstruction',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->im_reconstruction) ? null : Html::img(Petroglyph::SRC_IMAGE . '/' . $model->thumbnailImReconstr);
            }
        ],
        [
            'attribute' => 'im_overlay',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->im_overlay) ? null : Html::img(Petroglyph::SRC_IMAGE . '/' . $model->thumbnailImOverlay);
            }
        ],
    ],
]) ?>

    <br>

    <div class="clearfix"></div>

    <h3><?= Yii::t('manager', 'Compositions') ?></h3>

    <div class="text-right">
        <?= Html::a(Yii::t('manager', 'Add Composition'), ['manager/composition-create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
    <br>

    <div class="clearfix"></div>

<?= GridView::widget([
    'dataProvider' => $providerComposition,
    'columns' => [
        'id',
        'index',
        [
            'attribute' => 'image',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->image) ? null : Html::img(Composition::SRC_IMAGE . '/' . $model->thumbnailImage, ['width' => 100]);
            }
        ],
        [
            'class' => 'backend\grid\ActionColumn',
            'options' => ['style' => 'width: 100px;'],
            'buttons' => [
                'view' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-eye"></span>',
                        ['manager/composition-view', 'id' => $model->id]);
                },
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-edit"></span>',
                        ['manager/composition-update', 'id' => $model->id]);
                },
                'delete' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-trash"></span>',
                        ['manager/composition-delete', 'id' => $model->id],
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

    <br>

    <div class="clearfix"></div>

    <h3><?= Yii::t('manager', 'Additional Images') ?></h3>

    <div class="text-right">
        <?= Html::a(Yii::t('manager', 'Add Image'), ['manager/petroglyph-image-create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>

    <br>

    <div class="clearfix"></div>

<?= GridView::widget([
    'dataProvider' => $providerImage,
    'columns' => [
        'id',
        'name',
        [
            'attribute' => 'file',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->file) ? null : Html::img(PetroglyphImage::SRC_IMAGE . '/' . $model->thumbnailImage, ['width' => 100]);
            }
        ],
        [
            'class' => 'backend\grid\ActionColumn',
            'options' => ['style' => 'width: 100px;'],
            'buttons' => [
                'view' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-eye"></span>',
                        ['manager/petroglyph-image-view', 'id' => $model->id]);
                },
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-edit"></span>',
                        ['manager/petroglyph-image-update', 'id' => $model->id]);
                },
                'delete' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-trash"></span>',
                        ['manager/petroglyph-image-delete', 'id' => $model->id],
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

    <br>

    <div class="clearfix"></div>

    <h3><?= Yii::t('manager', '3D Model') ?></h3>

    <div class="text-right">
        <?= Html::a(Yii::t('manager', 'Add 3D model'), ['manager/petroglyph-three-d-create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>

    <br>

    <div class="clearfix"></div>

<?= GridView::widget([
    'dataProvider' => $providerThreeD,
    'columns' => [
        'id',
        'name',
        'url',
        [
            'class' => 'backend\grid\ActionColumn',
            'options' => ['style' => 'width: 100px;'],
            'buttons' => [
                'view' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-eye"></span>',
                        ['manager/petroglyph-three-d-view', 'id' => $model->id]);
                },
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-edit"></span>',
                        ['manager/petroglyph-three-d-update', 'id' => $model->id]);
                },
                'delete' => function ($url, $model) {
                    return \yii\helpers\Html::a(
                        '<span class="fas fa-trash"></span>',
                        ['manager/petroglyph-three-d-delete', 'id' => $model->id],
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