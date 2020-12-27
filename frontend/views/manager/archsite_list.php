<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('manager', 'Archsites');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('manager', 'Management'), 'url' => ['/manager/index']],
    $this->title,
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="clearfix">
    <div class="pull-right">
        <?= Html::a(Yii::t('manager', 'Add archsite'), ['manager/archsite-create'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<br>

<?php if (!empty($archsites)): ?>
    <table class="table table-responsive table-hover">
        <thead>
        <tr>
            <th>№</th>
            <th><?=Yii::t('manager', 'Name')?></th>
            <th></th>
        </tr>
        </thead>
        <?php /** @var \common\models\Archsite $item */
        foreach ($archsites as $i => $item): ?>
            <tr>
                <td>
                    <?= ($i + 1) ?>
                <td>
                    <?= $item->name ?>
                </td>
                <td>
                    <?= Html::a(Yii::t('app','Edit'), ['manager/archsite-update', 'id' => $item->id], ['class' => 'btn btn-primary']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>