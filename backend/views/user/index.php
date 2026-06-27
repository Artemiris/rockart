<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

$this->title = 'Пользователи';
$this->params['breadcrumbs'] = [
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="text-right">
    <?= Html::a('Добавить', ['user/create'], ['class' => 'btn btn-primary']) ?>
</div>

<br>

<div class="clearfix"></div>

<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'username',
        'email',
        'status',
        [
            'label' => 'Роли',
            'value' => function ($model) {
                $roles = \Yii::$app->authManager->getRolesByUser($model->id);
                $result = null;
                if (!empty($roles)) {
                    $array_ = ArrayHelper::map($roles, 'name', 'description');
                    $result = implode(', ', $array_);
                }

                return $result;
            }
        ],
        [
            'class' => 'backend\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'options' => ['width' => '100']
        ]
    ],
]) ?>
