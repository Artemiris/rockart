<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\PetroglyphThreeD */

use yii\helpers\Html;
use yii\widgets\DetailView;

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
        <?= Html::a(Yii::t('manager', 'Edit'), ['manager/petroglyph-three-d-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if (empty($model->deleted)): ?>
            <?= Html::a(Yii::t('manager', 'Delete'), ['manager/petroglyph-three-d-delete', 'id' => $model->id], [
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
        'url',
    ],
]) ?>