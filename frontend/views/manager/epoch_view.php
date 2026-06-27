<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\Epoch */

use yii\helpers\Html;
use yii\widgets\DetailView;

$name = 'name_' . Yii::$app->language;
$this->title = $model->$name;
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('manager', 'Epoch'), 'url' => ['/manager/epoch']],
    $this->title,
];
?>

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="text-right">
        <?= Html::a(Yii::t('manager', 'Edit'), ['manager/epoch-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('manager', 'Delete'), ['manager/epoch-delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('manager', 'Do you really want to delete?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <br>

    <div class="clearfix"></div>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'name_en',
    ],
]) ?>