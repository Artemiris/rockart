<?php

/* @var $this yii\web\View */

/* @var $archsite Archsite */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Archsite;
use common\models\Petroglyph;

$this->title = $archsite->name;

$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Archsites'), 'url' => ['archsite/index']],
    $this->title,
];


$script = <<< JS

$(document).ready(function () {
    var container = $('.collection');

    container.imagesLoaded(function () {
        container.masonry();
    });
});

JS;

$this->registerJsFile('/js/masonry/masonry.pkgd.min.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$this->registerJsFile('/js/masonry/imagesloaded.pkgd.min.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$this->registerJsFile('/js/archsitemanage.js');
$this->registerJs($script, yii\web\View::POS_READY);
$this->registerCssFile('css/archsite.css?20200317', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
$this->registerCssFile('css/petroglyph.css', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
?>

<?= newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=findImages]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '70%',
        'height' => '70%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]) ?>


<?php if (empty($archsite->image)): ?>
    <?php if (Yii::$app->user->can('manager')): ?>
        <?= Html::a(Yii::t('app', 'Edit'), ['manager/archsite-update', 'id' => $archsite->id], ['class' => 'btn btn-primary pull-right']) ?>
    <?php endif; ?>
    <h1><?= Html::encode($archsite->name) ?></h1>
    <?= $archsite->description ?>
<?php else: ?>
    <div class="pull-left poster col-xs-6">
        <?= Html::a(Html::img(Archsite::SRC_IMAGE . '/' . $archsite->thumbnailImage, [
            'class' => 'img-responsive'
        ]), Archsite::SRC_IMAGE . '/' . $archsite->image, [
            'rel' => 'findImages'
        ]); ?>
    </div>
    <?php if (Yii::$app->user->can('manager')): ?>
        <?= Html::a(Yii::t('app', 'Edit'), ['manager/archsite-update', 'id' => $archsite->id], ['class' => 'btn btn-primary pull-right']) ?>
    <?php endif; ?>
    <h1><?= Html::encode($archsite->name) ?></h1>
    <?= $archsite->description ?>
<?php endif; ?>
<?php if (!empty($archsite->publication)): ?>
    <h3><?= Yii::t('app', 'Publications') ?></h3>
    <?= $archsite->publication ?>
<?php endif; ?>

<div class="clearfix"></div>

<?php if (!empty($archsite->petroglyphs)): ?>
    <h2><?= Yii::t('app', 'Panels') ?></h2>
    <div class="form-group">
        <button type="button" id="vieworigin" class="btn btn-primary"><?= Yii::t('manager', 'View original images')?></button>
        <button type="button" id="viewdstretch" class="btn btn-primary"><?= Yii::t('manager', 'View images DStretch')?></button>
        <button type="button" id="viewdrawing" class="btn btn-primary"><?= Yii::t('manager', 'View drawing')?></button>
        <button type="button" id="viewreconstruction" class="btn btn-primary"><?= Yii::t('manager', 'View reconstruction')?></button>
        <button type="button" id="viewoverlay" class="btn btn-primary"><?= Yii::t('manager', 'View overlay images')?></button>
    </div>
    <div class="row collection">

        <?php foreach ($archsite->petroglyphs as $petroglyph): ?>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <?php if (!empty($petroglyph->image)): ?>
                    
                    <a href="<?= Url::to(['petroglyph/view', 'id' => $petroglyph->id]) ?>" class="petroglyph-item" >
                        <div class="row" id="<?=$petroglyph->id?>">
                            <div class="image-origin" style="display:block">
                                <?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImage, ['class' => 'img-responsive']) ?>
                            </div>
                            <?php if (!empty($petroglyph->im_dstretch)): ?>
                                <div class="image-dstretch" style="display: none">
                                    <?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDstretch, ['class' => 'img-responsive']) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($petroglyph->im_drawing)): ?>
                                <div class="image-drawing" style="display: none">
                                    <?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDrawing, ['class' => 'img-responsive']) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($petroglyph->im_reconstruction)): ?>
                                <div class="image-reconstruction" style="display:none">
                                    <?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImReconstr, ['class' => 'img-responsive']) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($petroglyph->im_overlay)): ?>
                                <div class="image-overlay" style="display:none">
                                    <?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImOverlay, ['class' => 'img-responsive']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <h4>
                            <?php if (!empty($petroglyph->index)):?><?= $petroglyph->index ?>. <?endif?><?= $petroglyph->name ?>
                        </h4>
                        <?/*= $petroglyph->annotation */?>
                    </a>
                <?php endif; ?>
                
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>