<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\Archsite */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use common\models\News;
use mihaildev\ckeditor\CKEditor;

$this->title = Yii::t('manager', 'New archsite');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('model', 'Archsites'), 'url' => ['/manager/archsite']],
    $this->title,
];

?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_archsite_form', [
    'model' => $model
]) ?>