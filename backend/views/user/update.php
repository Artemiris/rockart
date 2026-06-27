<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\Culture */

use yii\helpers\Html;

$this->title = 'Редактирование';
$this->params['breadcrumbs'] = [
    ['label' => 'Пользователи', 'url' => ['index']],
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
    'roles' => $roles,
    'permissions' => $permissions,
]) ?>
