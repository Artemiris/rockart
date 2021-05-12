<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $petroglyph Petroglyph */

use common\models\Petroglyph;
use common\models\PetroglyphImage;
use common\models\Composition;
use yii\helpers\Html;

$this->title = $petroglyph->name;
$archsite = \common\models\Archsite::find()->where(['id'=>$petroglyph->archsite_id])->one();
$archsiteURL = $archsite == null ? null : '/archsite/'.$archsite->id;
if($archsite != null){
    $this->params['breadcrumbs'] = [
        ['label' => Yii::t('app','Sites'), 'url' => '/archsite'],
        ['label' => $archsite->name, 'url' => $archsiteURL],
    ];
}else{
    $this->params['breadcrumbs'] = [
        ['label' => Yii::t('app','Petroglyphs'), 'url' => '/petroglyph'],
    ];
}

$iauthor = Yii::t('model', 'Image authors');
$icopyright = Yii::t('model', 'Image copyright');
$isource = Yii::t('model', 'Image source');

$area = $petroglyph->area_id == null ? null : \common\models\Area::find()->where(['id'=>$petroglyph->area_id])->one();
$areaURL = $area == null ? '' : '/area/'.$area->id;

$this->registerCssFile('css/petroglyph.css?21042021', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
if($area != null){
    $this->params['breadcrumbs'][] = [
        'label' => $area->name, 'url' => $areaURL,
    ];
}
$this->params['breadcrumbs'][] = [
    'label'=>$this->title,
];

//$mdCol = Yii::$app->user->can('manager') ? 3 : 4;
$lang = json_encode(Yii::$app->language);
$author = json_encode(Yii::t('model', 'Model authors'));
$copyright = json_encode(Yii::t('model', 'Model copyright'));

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

    if (Yii::$app->user->can('manager')) {
        $this->registerJsFile('/js/map/jquery.cookie.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);

        if ($mapProvider == 'yandex') {
            $this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=' . (Yii::$app->language == 'ru' ? 'ru_RU' : 'en_US') . '&mode=debug', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
            $this->registerJsFile('/js/map/tiler-converter.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
            $this->registerJsFile('/js/map/map_yandex.js?20200501', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
        } else {
            $this->registerJsFile('/js/map/markerclusterer/src/markerclusterer.js', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
            $this->registerJsFile('/js/map/map.js?20200501', ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
            $this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyCeYhPhJAnwj95GXDg5BRT7Q2dTj303dQU&callback=initMap&language=' . Yii::$app->language, ['depends' => ['yii\bootstrap\BootstrapPluginAsset']]);
        }
    }
}


$script = <<< JS
        
        $('[data-toggle="tooltip"]').tooltip();

        $(document).ready(function() {
            $('.f3d').each(function () {
                let self = $(this);
                let modelID = self.attr('href').split('/').slice(-1)[0];
                let domain = self.attr('href').split('/');
                let modelURL = domain[0] + '//' + domain[2] + '/ru/rest/copyright?id=' + modelID + '&lng=' + $lang;
                $.ajax({
                    url: modelURL,
                    success: function(data) {
                        let d = JSON.parse(data);
                        let aVal = (d.author || '');
                        let cVal = (d.copyright || '');
                        let cblock = '';
                        if(d.author || d.copyright){
                            if(d.author) cblock += $author + ': ' + aVal;
                            if(d.author && d.copyright) cblock += '</br>';
                            if(d.copyright) cblock += $copyright + ': ' + cVal;
                        }
                        self.attr('data-caption',cblock);
                    }
                });
            });
        });

JS;

$this->registerJs($script, yii\web\View::POS_READY);
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
        'beforeShow' => new \yii\web\JsExpression("function(){ if($(this.element).attr('data-caption') !== '') {this.title =" . "'<p class=\"authors-block\">' + " . " $(this.element).attr('data-caption') " . "+ '</p>'};}"),
        'helpers' => [
            'title' => ['type' => 'inside'],
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
        <?php
            $iauthorset = isset($petroglyph->img_author) && !empty($petroglyph->img_author);
            $icopyrightset = isset($petroglyph->img_copyright) && !empty($petroglyph->img_copyright);
            $isourceset = isset($petroglyph->img_source) && !empty($petroglyph->img_source);
        ?>
        <?= Html::a(Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImage, [
            'class' => 'img-responsive',
            'title' => ($iauthorset ? "© " . $petroglyph->img_author : "")
                . ($icopyrightset ? "\n© " . $petroglyph->img_copyright : "")
                . ($isourceset ? "\n© " . $petroglyph->img_source : ""),
        ]), Petroglyph::SRC_IMAGE . '/' . $petroglyph->image, [
            'rel' => 'petroglyphImages',
            'data-caption' => ($iauthorset ? $iauthor . ": " . $petroglyph->img_author : "")
                . ($icopyrightset ?  "<br>" . $icopyright . ": " .  $petroglyph->img_copyright : "")
                . ($isourceset ? "<br>" . $isource . ": " . $petroglyph->img_source : ""),
        ]); ?>
        <div id="icopyright" style="width:100%">
            <?= '<p class="authors-block">' . ($iauthorset ? $iauthor . ": " . $petroglyph->img_author : "")
            . ($icopyrightset ? "<br>" . $icopyright . ": " .  $petroglyph->img_copyright : "")
            . ($isourceset ? "<br>" . $isource . ": " . $petroglyph->img_source : "") . '</p>'?>
        </div>
        </div>
    <?endif;?>
    
    <?php if (!empty($petroglyph->im_dstretch)): ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 image">
            <?php
                $iauthorset = isset($petroglyph->ds_img_author) && !empty($petroglyph->ds_img_author);
                $icopyrightset = isset($petroglyph->ds_img_copyright) && !empty($petroglyph->ds_img_copyright);
                $isourceset = isset($petroglyph->ds_img_source) && !empty($petroglyph->ds_img_source);
            ?>
            <?= Html::a(Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDstretch, [
                'class' => 'img-responsive',
                'title' => ($iauthorset ? "© " . $petroglyph->ds_img_author : "")
                    . ($icopyrightset ? "\n© " . $petroglyph->ds_img_copyright : "")
                    . ($isourceset ? "\n© " . $petroglyph->ds_img_source : ""),
            ]), Petroglyph::SRC_IMAGE . '/' . $petroglyph->im_dstretch, [
                'rel' => 'petroglyphImages',
                'data-caption' => ($iauthorset ? $iauthor . ": " . $petroglyph->ds_img_author : "")
                    . ($icopyrightset ?  "<br>" . $icopyright . ": " .  $petroglyph->ds_img_copyright : "")
                    . ($isourceset ? "<br>" . $isource . ": " . $petroglyph->ds_img_source : ""),
            ]); ?>
        </div>
    <?endif;?>
    <?php if (!empty($petroglyph->im_drawing)): ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 image">
            <?php
                $iauthorset = isset($petroglyph->dr_img_author) && !empty($petroglyph->dr_img_author);
                $icopyrightset = isset($petroglyph->dr_img_copyright) && !empty($petroglyph->dr_img_copyright);
                $isourceset = isset($petroglyph->dr_img_source) && !empty($petroglyph->dr_img_source);
            ?>
            <?= Html::a(Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDrawing, [
                'class' => 'img-responsive',
                'title' => ($iauthorset ? "© " . $petroglyph->dr_img_author : "")
                    . ($icopyrightset ? "\n© " . $petroglyph->dr_img_copyright : "")
                    . ($isourceset ? "\n© " . $petroglyph->dr_img_source : ""),
            ]), Petroglyph::SRC_IMAGE . '/' . $petroglyph->im_drawing, [
                'rel' => 'petroglyphImages',
                'data-caption' => ($iauthorset ? $iauthor . ": " . $petroglyph->dr_img_author : "")
                    . ($icopyrightset ?  "<br>" . $icopyright . ": " .  $petroglyph->dr_img_copyright : "")
                    . ($isourceset ? "<br>" . $isource . ": " . $petroglyph->dr_img_source : ""),
            ]); ?>
        </div>
    <?endif;?>
    <?php if (!empty($petroglyph->im_reconstruction)): ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 image">
            <?php
                $iauthorset = isset($petroglyph->re_img_author) && !empty($petroglyph->re_img_author);
                $icopyrightset = isset($petroglyph->re_img_copyright) && !empty($petroglyph->re_img_copyright);
                $isourceset = isset($petroglyph->re_img_source) && !empty($petroglyph->re_img_source);
            ?>
            <?= Html::a(Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImReconstr, [
                'class' => 'img-responsive',
                'title' => ($iauthorset ? "© " . $petroglyph->re_img_author : "")
                    . ($icopyrightset ? "\n© " . $petroglyph->re_img_copyright : "")
                    . ($isourceset ? "\n© " . $petroglyph->re_img_source : ""),
            ]), Petroglyph::SRC_IMAGE . '/' . $petroglyph->im_reconstruction, [
                'rel' => 'petroglyphImages',
                'data-caption' => ($iauthorset ? $iauthor . ": " . $petroglyph->re_img_author : "")
                    . ($icopyrightset ?  "<br>" . $icopyright . ": " .  $petroglyph->re_img_copyright : "")
                    . ($isourceset ? "<br>" . $isource . ": " . $petroglyph->re_img_source : ""),
            ]); ?>
        </div>
    <?endif;?>
    <?php if (!empty($petroglyph->im_overlay)): ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 image">
            <?php
                $iauthorset = isset($petroglyph->ov_img_author) && !empty($petroglyph->ov_img_author);
                $icopyrightset = isset($petroglyph->ov_img_copyright) && !empty($petroglyph->ov_img_copyright);
                $isourceset = isset($petroglyph->ov_img_source) && !empty($petroglyph->ov_img_source);
            ?>
            <?= Html::a(Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImOverlay, [
                'class' => 'img-responsive',
                'title' => ($iauthorset ? "© " . $petroglyph->ov_img_author : "")
                    . ($icopyrightset ? "\n© " . $petroglyph->ov_img_copyright : "")
                    . ($isourceset ? "\n© " . $petroglyph->ov_img_source : ""),
            ]), Petroglyph::SRC_IMAGE . '/' . $petroglyph->im_overlay, [
                'rel' => 'petroglyphImages',
                'data-caption' => ($iauthorset ? $iauthor . ": " . $petroglyph->ov_img_author : "")
                    . ($icopyrightset ?  "<br>" . $icopyright . ": " .  $petroglyph->ov_img_copyright : "")
                    . ($isourceset ? "<br>" . $isource . ": " . $petroglyph->ov_img_source : ""),
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
        <?= Html::a('PDF', ['petroglyph/pdf-view', 'id' => $petroglyph->id], ['class' => 'btn btn-primary pull-right']) ?>
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
<div class="row">
    <?php if (!empty($petroglyph->lat) && !empty($petroglyph->lng) && Yii::$app->user->can('manager')): ?>
            <div class="col-xs-6 col-sm-6 col-md-3">
                <?php
                $title = Yii::t('app', 'Coordinates');
                if (isset($inherit_coords)){
                    if ($inherit_coords == 'archsite')
                        $title = Yii::t('app', 'Coordinates (site)');
                    else if ($inherit_coords == 'area')
                        $title = Yii::t('app', 'Coordinates (area)');
                }
                echo $this->render('_panel', [
                    'title' => $title,
                    'data' => [$petroglyph->lat, $petroglyph->lng],
                ]) ?>
            </div>
    <?php endif; ?>
    <?php if (!empty($petroglyph->cultures)):?>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <?= $this->render('_panel', [
                'title' => Yii::t('app', 'Culture'),
                'data' => [(isset($petroglyph->cultures) ? implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->cultures)) : null)],
            ]) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($petroglyph->epochs)):?>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <?= $this->render('_panel', [
                'title' => Yii::t('app', 'Epoch'),
                'data' => [(isset($petroglyph->epochs) ? implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->epochs)) : null)],
            ]) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($petroglyph->methods)):?>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <?= $this->render('_panel', [
                'title' => Yii::t('app', 'Method'),
                'data' => [(isset($petroglyph->methods) ? implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->methods)) : null)],
            ]) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($petroglyph->styles)):?>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <?= $this->render('_panel', [
                'title' => Yii::t('app', 'Style'),
                'data' => [(isset($petroglyph->styles) ? implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->styles)) : null)],
            ]) ?>
        </div>
    <?php endif; ?>
</div>
    <?php if (!empty($petroglyph->threeD)):?>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h3><?= Yii::t('app', '3D Models') ?></h3>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 images">
            <?php foreach ($petroglyph->threeD as $item): ?>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="image">
                        <?= Html::a(Html::img(str_replace("/iframe/", "/object/poster/", $item->url), [
                            'class' => 'img-responsive img-thumbnail']), $item->url, [
                            'class' => 'fancybox f3d',
                            'rel' => 'petroglyphImages',
                            'data-fancybox-type' => 'iframe',
                            'id' => 'f3d',
                        ]) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

<?php if (!empty($petroglyph->compositions)): ?>

    <div class="clearfix"></div>
<div class="row">
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
<?php if (isset($petroglyph->author_page) && !empty($petroglyph->author_page)): ?>
    <div class="clearfix"></div>
    </br>
    <p class="page-author"><?= Yii::t('model', 'Page authors') . ': ' . $petroglyph->author_page ?></p>
<?php endif; ?>
