<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\PetroglyphThreeD */

use yii\helpers\Html;

$this->title = Yii::t('manager', 'Edit Image');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('manager', 'Petroglyph'), 'url' => ['/manager/petroglyph']],
    ['label' => $model->petroglyph->name, 'url' => ['/manager/petroglyph-view', 'id' => $model->petroglyph->id]],
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_petroglyph_three_d_form', [
    'model' => $model,
]) ?>
