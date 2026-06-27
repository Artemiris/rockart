<?php

/* @var $this yii\web\View */

/* @var $petroglyph \common\models\Petroglyph */

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = Yii::t('app', 'Petroglyphs');

$this->params['breadcrumbs'] = [
    $this->title,
];

$script = <<< JS

$(document).ready(function () {
    var container = $('.petroglyphs');

    container.imagesLoaded(function () {
        container.masonry();
    });
});

JS;

$this->registerCssFile('css/petroglyph.css', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$this->registerJsFile('/js/masonry/masonry.pkgd.min.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$this->registerJsFile('/js/masonry/imagesloaded.pkgd.min.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$this->registerJs($script, yii\web\View::POS_READY);
?>

<h1><?= Html::encode($this->title) ?></h1>

    <div class="container-fluid">
        <div class="row form-group">
            <form method='get'>
                <?php if (isset($hiddens)) echo $hiddens?>
                <div class="btn-group">
                    <input name="filter" type="text" class="form-control" placeholder="Search" value="<?= $filter ?>">
                </div>
                <div class="btn-group">
                    <button id="search_button" type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search" style="color: #ccc;"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

<?= ListView::widget([
    'dataProvider' => $provider,
    'layout' => "<div class='row petroglyphs'>{items}</div> <div class='clearfix'></div>{pager}",
    'itemOptions' => ['class' => 'col-xs-12 col-sm-6 col-md-4'],
    'itemView' => '_item_view',
]); ?>