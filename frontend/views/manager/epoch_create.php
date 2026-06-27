<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\Epoch */

use yii\helpers\Html;

$this->title = Yii::t('manager', 'Add');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('manager', 'Epoch'), 'url' => ['/manager/epoch']],
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_epoch_form', [
    'model' => $model,
]) ?>
