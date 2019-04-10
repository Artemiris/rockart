<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\Composition */

use yii\helpers\Html;

$this->title = Yii::t('manager', 'Add Composition');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('manager', 'Petroglyph'), 'url' => ['/manager/petroglyph']],
    ['label' => $petroglyph->name, 'url' => ['/manager/petroglyph-view', 'id' => $petroglyph->id]],
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_composition_form', [
    'model' => $model,
    'petroglyph' => $petroglyph,
]) ?>
