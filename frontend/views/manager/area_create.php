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

$this->title = 'Добавление участка';
$this->params['breadcrumbs'] = [
    ['label' => 'Управление контентом', 'url' => ['/manager/index']],
    ['label' => 'Участки', 'url' => ['/manager/area-list']],
    $this->title,
];

?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_area_form', [
    'model' => $model,
    'archsites' => $archsites
]) ?>