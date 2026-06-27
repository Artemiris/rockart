<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\User */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

$this->title = $model->username;
$this->params['breadcrumbs'] = [
    ['label' => 'Пользователи', 'url' => ['index']],
    $this->title,
];
?>

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="text-right">
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <br>

    <div class="clearfix"></div>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
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
    ],
]) ?>