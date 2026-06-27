<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $composition Composition */

use common\models\Composition;
use yii\helpers\Html;

$this->title = $composition->index;
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Compositions'), 'url' => ['composition/index']],
    ['label' => $composition->petroglyph->name, 'url' => ['composition/view', 'id' => $composition->petroglyph->id]],
    $this->title,
];

$this->registerCssFile('css/composition.css', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);

$mdCol = Yii::$app->user->can('manager') ? 3 : 4;
?>


<?php if (empty($composition->image)): ?>
    <?php if (Yii::$app->user->can('manager')): ?>
        <?= Html::a(Yii::t('app', 'Edit'), ['manager/composition-update', 'id' => $composition->id], ['class' => 'btn btn-primary pull-right']) ?>
    <?php endif; ?>
    <h1><?= Html::encode($composition->index) ?></h1>
    <?= $composition->description ?>
<?php else: ?>
    <div class="pull-left poster">
        <?= Html::a(Html::img(Composition::SRC_IMAGE . '/' . $composition->thumbnailImage, [
            'class' => 'img-responsive'
        ]), Composition::SRC_IMAGE . '/' . $composition->image, [
            'rel' => 'compositionImages'
        ]); ?>
    </div>
    <?php if (Yii::$app->user->can('manager')): ?>
        <?= Html::a(Yii::t('app', 'Edit'), ['manager/composition-update', 'id' => $composition->id], ['class' => 'btn btn-primary pull-right']) ?>
    <?php endif; ?>

    <h1>
        <?= Html::encode($composition->index) ?>
    </h1>

    <?php if (!empty($composition->index)): ?>
       <h3><?= Yii::t('app', 'Index') . ': ' . $composition->index ?></h3>
    <?php endif; ?>
    <?php if (!empty($composition->description)): ?>
    <h3><?= Yii::t('app', 'Description') ?></h3>
    <?= $composition->description ?>
    <?php endif; ?>

<?php endif; ?>