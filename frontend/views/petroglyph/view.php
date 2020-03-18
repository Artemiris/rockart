<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $petroglyph Petroglyph */

use common\models\Petroglyph;
use common\models\PetroglyphImage;
use common\models\Composition;
use yii\helpers\Html;

$this->title = $petroglyph->name;
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Petroglyphs'), 'url' => ['petroglyph/index']],
    $this->title,
];

$this->registerCssFile('css/petroglyph.css', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);

//$mdCol = Yii::$app->user->can('manager') ? 3 : 4;

if ($json_petroglyphs) {
    $script = <<< JS

    var arr = $json_petroglyphs,
        map_center = '{"lat": ' + parseFloat(arr[0].lat) + ', "lng": ' + parseFloat(arr[0].lng) + '}',
        date = new Date();

    date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
    var expires = ";expires=" + date.toUTCString();

    document.cookie = "map_center=" + map_center + expires + ";path=/";
    
JS;

    $this->registerJs($script, yii\web\View::POS_BEGIN);

    $script = <<< JS
        
     $('[data-toggle="tooltip"]').tooltip();

JS;

    $this->registerJs($script, yii\web\View::POS_READY);

    if (Yii::$app->user->can('manager')) {
        $this->registerJsFile('/js/map/jquery.cookie.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);

        if ($mapProvider == 'yandex') {
            $this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=' . (Yii::$app->language == 'ru' ? 'ru_RU' : 'en_US') . '&mode=debug', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
            $this->registerJsFile('/js/map/tiler-converter.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
            $this->registerJsFile('/js/map/map_yandex.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
        } else {
            $this->registerJsFile('/js/map/markerclusterer/src/markerclusterer.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
            $this->registerJsFile('/js/map/map.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
            $this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyCeYhPhJAnwj95GXDg5BRT7Q2dTj303dQU&callback=initMap&language=' . Yii::$app->language, ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
        }
    }
}
?>

<?= newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=petroglyphImages]',
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
            'buttons' => [
            ],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]) ?>

    <div class="col-xs-12 col-sm-6 col-md-6">
    <?php if (!empty($petroglyph->image)): ?>
    <div class="poster">
        <?= Html::a(Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImage, [
            'class' => 'img-responsive'
        ]), Petroglyph::SRC_IMAGE . '/' . $petroglyph->image, [
            'rel' => 'petroglyphImages'
        ]); ?>
        </div>
    <?endif;?>
    
    <?php if (!empty($petroglyph->im_dstretch)): ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 image">
            <?= Html::a(Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDstretch, [
                'class' => 'img-responsive'
            ]), Petroglyph::SRC_IMAGE . '/' . $petroglyph->im_dstretch, [
                'rel' => 'petroglyphImages'
            ]); ?>
        </div>
    <?endif;?>
    <?php if (!empty($petroglyph->im_drawing)): ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 image">
            <?= Html::a(Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDrawing, [
                'class' => 'img-responsive'
            ]), Petroglyph::SRC_IMAGE . '/' . $petroglyph->im_drawing, [
                'rel' => 'petroglyphImages'
            ]); ?>
        </div>
    <?endif;?>
    <?php if (!empty($petroglyph->im_reconstruction)): ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 image">
            <?= Html::a(Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImReconstr, [
                'class' => 'img-responsive'
            ]), Petroglyph::SRC_IMAGE . '/' . $petroglyph->im_reconstruction, [
                'rel' => 'petroglyphImages'
            ]); ?>
        </div>
    <?endif;?>
    <?php if (!empty($petroglyph->im_overlay)): ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 image">
            <?= Html::a(Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImOverlay, [
                'class' => 'img-responsive'
            ]), Petroglyph::SRC_IMAGE . '/' . $petroglyph->im_overlay, [
                'rel' => 'petroglyphImages'
            ]); ?>
        </div>
    <?endif;?>

    <?php if (!empty($petroglyph->images)): ?>
        <?php foreach ($petroglyph->images as $item): ?>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 image">
                    <?= Html::a(Html::img(PetroglyphImage::SRC_IMAGE . '/' . $item->thumbnailImage, [
                        'class' => 'img-responsive img-thumbnail'
                    ]), PetroglyphImage::SRC_IMAGE . '/' . $item->file, [
                        'rel' => 'petroglyphImages'
                    ]); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    </div>
    <div class="col-xs-12 col-sm-6 col-md-6">
    <?php if (Yii::$app->user->can('manager')): ?>
        <?= Html::a(Yii::t('app', 'Edit'), ['manager/petroglyph-update', 'id' => $petroglyph->id], ['class' => 'btn btn-primary pull-right']) ?>
    <?php endif; ?>

    <h1>
        <?= Html::encode($petroglyph->name) ?>
    </h1>

    <?php if (!empty($petroglyph->index)): ?>
       <h3><?= Yii::t('app', 'Index') . ': ' . $petroglyph->index ?></h3>
    <?php endif; ?>
    <?php if (!empty($petroglyph->description)): ?>
    <h3><?= Yii::t('app', 'Description') ?></h3>
    <?= $petroglyph->description ?>
    <?php endif; ?>
    <?php if (!empty($petroglyph->technical_description)): ?>
        <h3><?= Yii::t('app', 'Technical description') ?></h3>
        <?= $petroglyph->technical_description ?>
    <?php endif; ?>
    <?php if (!empty($petroglyph->publication)): ?>

        <div class="clearfix"></div>
        <h3><?= Yii::t('app', 'Publications') ?></h3>
        <?= $petroglyph->publication ?>

    <?php endif; ?>
    </div>
    <?php if (!empty($petroglyph->lat) && !empty($petroglyph->lng) && Yii::$app->user->can('manager')): ?>
            <div class="col-xs-6 col-sm-6 col-md-3">
                <?php
                if (isset($inherit_coords) && $inherit_coords == 'archsite') $title = Yii::t('app', 'Coordinates (site)');
                else  $title = Yii::t('app', 'Coordinates');
                echo $this->render('_panel', [
                    'title' => $title,
                    'data' => [$petroglyph->lat, $petroglyph->lng],
                ]) ?>
            </div>
    <?php endif; ?>
    <?php if (!empty($petroglyph->culture)):?>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <?= $this->render('_panel', [
                'title' => Yii::t('app', 'Culture'),
                'data' => [(isset($petroglyph->culture) ? $petroglyph->culture->name : null)],
            ]) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($petroglyph->epoch)):?>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <?= $this->render('_panel', [
                'title' => Yii::t('app', 'Epoch'),
                'data' => [(isset($petroglyph->epoch) ? $petroglyph->epoch->name : null)],
            ]) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($petroglyph->method)):?>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <?= $this->render('_panel', [
                'title' => Yii::t('app', 'Method'),
                'data' => [(isset($petroglyph->method) ? $petroglyph->method->name : null)],
            ]) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($petroglyph->style)):?>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <?= $this->render('_panel', [
                'title' => Yii::t('app', 'Style'),
                'data' => [(isset($petroglyph->style) ? $petroglyph->style->name : null)],
            ]) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($petroglyph->threeD)):?>
    <div class="col-xs-12 col-sm-6 col-md-6">
        <h3><?= Yii::t('app', '3D Models') ?></h3>
        <?php foreach ($petroglyph->threeD as $item): ?>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                <?= Html::a(Html::img(str_replace("/iframe/", "/object/poster/", $item->url), [
                    'class' => 'img-responsive img-thumbnail']), $item->url, [
                    'class' => 'fancybox',
                    'rel' => 'petroglyphImages',
                    'data-fancybox-type' => 'iframe',
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="clearfix"></div>

<?php if (!empty($petroglyph->compositions)): ?>

    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
    <h3><?= Yii::t('app', 'Compositions') ?></h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 images">
        <?php foreach ($petroglyph->compositions as $item): ?>
            <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="image">
                    <?= Html::a(Html::img(Composition::SRC_IMAGE . '/' . $item->thumbnailImage, [
                        'class' => 'img-responsive img-thumbnail'
                    ]), ['composition/view', 'id' => $item->id], [
                        'rel' => 'compositions'
                    ]); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($json_petroglyphs && Yii::$app->user->can('manager')): ?>

    <div class="clearfix"></div>
    <div class="pull-right hidden-xs">
        <?= Html::a('Google Maps', '?mapProvider=google', ['class' => 'btn ' . ($mapProvider != 'yandex' ? 'btn-primary' : 'btn-default')]) ?>
        <?= Html::a('Yandex Maps', '?mapProvider=yandex', ['class' => 'btn ' . ($mapProvider == 'yandex' ? 'btn-primary' : 'btn-default')]) ?>
    </div>
    <h3><?= Yii::t('app', 'Map') ?></h3>
    <div class="visible-xs">
        <div class="form-group">
            <?= Html::a('Google Maps', '?mapProvider=google', ['class' => 'btn ' . ($mapProvider != 'yandex' ? 'btn-primary' : 'btn-default')]) ?>
            <?= Html::a('Yandex Maps', '?mapProvider=yandex', ['class' => 'btn ' . ($mapProvider == 'yandex' ? 'btn-primary' : 'btn-default')]) ?>
        </div>
    </div>


    <div id="map_canvas" style="width:100%; height:600px; float:left; margin-right: 20px;"></div>

<?php endif; ?>