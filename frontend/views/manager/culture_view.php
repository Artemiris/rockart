<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\Culture */

use yii\helpers\Html;
use yii\widgets\DetailView;

$name = 'name_' . Yii::$app->language;
$this->title = $model->$name;
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('manager', 'Culture'), 'url' => ['/manager/culture']],
    $this->title,
];
?>

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="text-right">
        <?= Html::a(Yii::t('manager', 'Edit'), ['manager/culture-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('manager', 'Delete'), ['manager/culture-delete', 'id' => $model->id], [
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