<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('manager', 'Management');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<ul class="list-group">
    <li class="list-group-item">
        <?= Html::a(Yii::t('manager', 'Culture'), ['manager/culture']) ?>
    </li>
    <li class="list-group-item">
        <?= Html::a(Yii::t('manager', 'Epoch'), ['manager/epoch']) ?>
    </li>
    <li class="list-group-item">
        <?= Html::a(Yii::t('manager', 'Method'), ['manager/method']) ?>
    </li>
    <li class="list-group-item">
        <?= Html::a(Yii::t('manager', 'Style'), ['manager/style']) ?>
    </li>
    <li class="list-group-item">
        <?= Html::a(Yii::t('manager', 'Petroglyph'), ['manager/petroglyph']) ?>
    </li>
    <li class="list-group-item">
        <?= Html::a(Yii::t('manager', 'Archsite'), ['manager/archsite']) ?>
    </li>
    <li class="list-group-item">
        <?= Html::a(Yii::t('manager', 'Area'), ['manager/area-list']) ?>
    </li>
</ul>
