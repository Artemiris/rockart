<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model Composition */

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Composition;
use yii\grid\GridView;

$this->title = $model->index;
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('manager', 'Petroglyph'), 'url' => ['/manager/petroglyph']],
    ['label' => $model->petroglyph->name, 'url' => ['/manager/petroglyph-view', 'id' => $model->petroglyph->id]],
    $this->title,
];
?>

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="text-right">
        <?= Html::a(Yii::t('manager', 'Edit'), ['manager/composition-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if (empty($model->deleted)): ?>
            <?= Html::a(Yii::t('manager', 'Delete'), ['manager/composition-delete', 'id' => $model->id], [
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
        'index',
        [
            'attribute' => 'description',
            'format' => 'html',
        ],
        [
            'attribute' => 'description_en',
            'format' => 'html',
        ],
        [
            'attribute' => 'image',
            'format' => 'html',
            'value' => function ($model) {
                return empty($model->image) ? null : Html::img(Composition::SRC_IMAGE . '/' . $model->thumbnailImage);
            }
        ],
    ],
]) ?>