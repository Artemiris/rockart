<?php

/* @var $this yii\web\View */

/* @var $site \common\models\Archsite */

use yii\helpers\Html;
use common\models\Archsite;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Archsites');

$this->params['breadcrumbs'] = [
    $this->title,
];

$script = <<< JS

$(document).ready(function () {
    var container = $('.archsites');

    container.imagesLoaded(function () {
        container.masonry();
    });
});

JS;

$this->registerCssFile('css/archsite.css?20200317', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$this->registerJsFile('/js/masonry/masonry.pkgd.min.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$this->registerJsFile('/js/masonry/imagesloaded.pkgd.min.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$this->registerJs($script, yii\web\View::POS_READY);
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (!empty($archsites)): ?>
    <div class="archsites row">
        <?php foreach ($archsites as $archsite): ?>
            <div class="col-xs-12 col-sm-6">
                <a href="<?= Url::to(['archsite/view', 'id' => $archsite->id]) ?>" class="archsite-item">
                        <div class="row">
                            <?= Html::img(Archsite::SRC_IMAGE . '/' . $archsite->thumbnailImage, ['class' => 'img-responsive']) ?>
                        </div>
                        <h3>
                            <?= $archsite->name ?>
                        </h3>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
