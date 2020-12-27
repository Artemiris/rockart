<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Area */
/* @var $archsites Array */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use common\models\News;
use mihaildev\ckeditor\CKEditor;

$this->title = Yii::t('manager', 'Area editor');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('model', 'Areas'), 'url' => ['/manager/area-list']],
    $this->title,
];

?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="clearfix">
    <?= Html::a(Yii::t('app', 'View'), ['area/view', 'id' => $model->id]) ?>
    <div class="pull-right">
        <?= Html::a(Yii::t('manager', 'Delete'), [
            'manager/area-delete',
            'id' => $model->id
        ], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('manager', 'Do you really want to delete?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
</div>

<?= $this->render('_area_form', [
    'model' => $model,
    'archsites' => $archsites
]) ?>