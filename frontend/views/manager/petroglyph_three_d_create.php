<?php

/*Yii::t('manager', 'Epoch')@var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\PetroglyphThreeD */
/* @var $petroglyph \common\models\Petroglyph */

use yii\helpers\Html;

$this->title = Yii::t('manager', 'Add Image');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('manager', 'Petroglyph'), 'url' => ['/manager/petroglyph']],
    ['label' => $petroglyph->name, 'url' => ['/manager/petroglyph-view', 'id' => $petroglyph->id]],
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_petroglyph_three_d_form', [
    'model' => $model,
    'petroglyph' => $petroglyph,
]) ?>
