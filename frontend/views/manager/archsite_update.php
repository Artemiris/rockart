<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\Archsite */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use common\models\News;
use mihaildev\ckeditor\CKEditor;

$this->title = Yii::t('manager', 'Archsite editor');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('manager', 'Archsites'), 'url' => ['/manager/archsite']],
    $this->title,
];
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="clearfix">
    <?= Html::a(Yii::t('app', 'View'), ['archsite/view', 'id' => $model->id]) ?>
    <div class="pull-right">
        <?= Html::a(Yii::t('manager', 'Delete'), [
            'manager/archsite-delete',
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

<br>

<?= $this->render('_archsite_form', [
    'model' => $model
]) ?>