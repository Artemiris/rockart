<?php

/* @var $this yii\web\View */
/* @var $models Array */
/* @var $archsites Array */

use yii\helpers\Html;

$this->title = 'Участки';
$this->params['breadcrumbs'] = [
    ['label' => 'Управление контентом', 'url' => ['/manager/index']],
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="clearfix">
    <div class="pull-right">
        <?= Html::a('Добавить участок', ['manager/area-create'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<br>

<?php if (!empty($models)): ?>
    <table class="table table-responsive table-hover">
        <thead>
        <tr>
            <th>№</th>
            <th>Название</th>
            <th>Памятник</th>
            <th></th>
        </tr>
        </thead>
        <?php /** @var \common\models\Area $item */
        foreach ($models as $i => $item): ?>
            <tr>
                <td>
                    <?= ($i + 1) ?>
                <td>
                    <?= $item->name ?>
                </td>
                <td>
                    <?= $archsites[$item->archsite_id] ?>
                </td>
                </td>
                <td>
                    <?= Html::a('Перейти', ['manager/area-update', 'id' => $item->id], ['class' => 'btn btn-primary']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
