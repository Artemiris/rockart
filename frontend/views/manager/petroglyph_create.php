<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\Petroglyph */
/* @var $areas Array */

use yii\helpers\Html;

$this->title = Yii::t('manager', 'Add');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    ['label' => Yii::t('manager', 'Petroglyph'), 'url' => ['/manager/petroglyph']],
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_petroglyph_form', [
    'model' => $model,
    'archsites' => $archsites,
    'cultures' => $cultures,
    'epochs' => $epochs,
    'methods' => $methods,
    'styles' => $styles,
    'areas' => $areas
]) ?>
