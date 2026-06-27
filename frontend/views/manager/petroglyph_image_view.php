<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model PetroglyphImage */

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PetroglyphImage;
use yii\grid\GridView;

$this->title = $model->name;
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('manager', 'Petroglyph'), 'url' => ['/manager/petroglyph']],
    ['label' => $model->petroglyph->name, 'url' => ['/manager/petroglyph-view', 'id' => $model->petroglyph->id]],
    $this->title,
];
?>

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="text-right">
        <?= Html::a(Yii::t('manager', 'Edit'), ['manager/petroglyph-image-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if (empty($model->deleted)): ?>
            <?= Html::a(Yii::t('manager', 'Delete'), ['manager/petroglyph-image-delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('manager', 'Do you really want to delete?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </div>

    <br>

    <div class="clearfix"></div>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'name_en',
        [
            'attribute' => 'description',
            'format' => 'html',
        ],
        [
            'attribute' => 'description_en',
            'format' => 'html',
        ],
        [
            'attribute' => 'file',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->file) ? null : Html::img(PetroglyphImage::SRC_IMAGE . '/' . $model->thumbnailImage);
            }
        ],
    ],
]) ?>