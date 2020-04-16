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

?>

<div class="container-fluid">
    <div class="row form-group">
<div class="btn-group">
    <button id="imagetype_button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= Yii::t('manager', 'View original images')?> <span class="caret"></span>
    </button>
    <ul id="imagetype_dropdown" class="dropdown-menu">
        <?php foreach ($archsite->petroglyphs as $petroglyph):?>
            <?php if (!empty($petroglyph->image)): ?>
                <li><a href="#" id="vieworigin"><?= Yii::t('app', 'View original images')?></a></li>
            <?php break; endif; ?>
        <?php endforeach; ?>
        <?php foreach ($archsite->petroglyphs as $petroglyph):?>
            <?php if (!empty($petroglyph->im_dstretch)): ?>
                <li><a href="#" id="viewdstretch"><?= Yii::t('app', 'View images DStretch')?></a></li>
            <?php break; endif; ?>
        <?php endforeach; ?>
        <?php foreach ($archsite->petroglyphs as $petroglyph):?>
            <?php if (!empty($petroglyph->im_drawing)): ?>
                <li><a href="#" id="viewdrawing"><?= Yii::t('app', 'View drawing')?></a></li>
                <?php break; endif; ?>
        <?php endforeach; ?>
        <?php foreach ($archsite->petroglyphs as $petroglyph):?>
            <?php if (!empty($petroglyph->im_reconstruction)): ?>
                <li><a href="#" id="viewreconstruction"><?= Yii::t('app', 'View reconstruction')?></a></li>
                <?php break; endif; ?>
        <?php endforeach; ?>
        <?php foreach ($archsite->petroglyphs as $petroglyph):?>
            <?php if (!empty($petroglyph->im_overlay)): ?>
                <li><a href="#" id="viewoverlay"><?= Yii::t('app', 'View overlay images')?></a></li>
                <?php break; endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
<div class="btn-group">
    <button id="epoch_button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="epoch_all">
        <?= Yii::t('app', 'All epochs')?> <span class="caret"></span>
    </button>
    <ul id="epoch_dropdown" class="dropdown-menu">
        <li><a id="epoch_all" href="#"><?= Yii::t('app', 'All epochs')?></a></li>
        <?php
            $epochs = array();
            foreach ($archsite->petroglyphs as $petroglyph) {
                if (!empty($petroglyph->epochs)) {
                    foreach ($petroglyph->epochs as $epoch) {
                        if (!isset($epochs[$epoch->name])) {
                            $epochs[$epoch->name]['id'] = $epoch->id;
                            $epochs[$epoch->name]['count'] = 1;
                        }
                        else $epochs[$epoch->name]['count']++;
                    }
                }
            }
            arsort($epochs);
            foreach ($epochs as $epoch_name => $epoch_data){
        ?>
        <li><a href="#" id="epoch_<?= $epoch_data['id']?>"><?= $epoch_name?> (<?= $epoch_data['count']?>)</a></li>
        <?php } ?>
    </ul>
</div>
<div class="btn-group">
    <button id="culture_button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="culture_all">
        <?= Yii::t('app', 'All cultures')?> <span class="caret"></span>
    </button>
    <ul id="culture_dropdown" class="dropdown-menu">
        <li><a id="culture_all" href="#"><?= Yii::t('app', 'All cultures')?></a></li>
        <?php
        $cultures = array();
        foreach ($archsite->petroglyphs as $petroglyph) {
            if (!empty($petroglyph->cultures)) {
                foreach ($petroglyph->cultures as $culture) {
                    if (!isset($cultures[$culture->name])) {
                        $cultures[$culture->name]['id'] = $culture->id;
                        $cultures[$culture->name]['count'] = 1;
                    }
                    else $cultures[$culture->name]['count']++;
                }
            }
        }
        arsort($cultures);
        foreach ($cultures as $culture_name => $culture_data){
            ?>
            <li><a href="#" id="culture_<?= $culture_data['id']?>"><?= $culture_name?> (<?= $culture_data['count']?>)</a></li>
        <?php } ?>
    </ul>
</div>
<div class="btn-group">
    <button id="method_button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="method_all">
        <?= Yii::t('app', 'All methods')?> <span class="caret"></span>
    </button>
    <ul id="method_dropdown" class="dropdown-menu">
        <li><a id="method_all" href="#"><?= Yii::t('app', 'All methods')?></a></li>
        <?php
        $methods = array();
        foreach ($archsite->petroglyphs as $petroglyph) {
            if (!empty($petroglyph->methods)) {
                foreach ($petroglyph->methods as $method) {
                    if (!isset($methods[$method->name])) {
                        $methods[$method->name]['id'] = $method->id;
                        $methods[$method->name]['count'] = 1;
                    }
                    else $methods[$method->name]['count']++;
                }
            }
        }
        arsort($methods);
        foreach ($methods as $method_name => $method_data){
            ?>
            <li><a href="#" id="method_<?= $method_data['id']?>"><?= $method_name?> (<?= $method_data['count']?>)</a></li>
        <?php } ?>
    </ul>
</div>
<div class="btn-group">
    <button id="style_button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="style_all">
        <?= Yii::t('app', 'All styles')?> <span class="caret"></span>
    </button>
    <ul id="style_dropdown" class="dropdown-menu">
        <li><a id="style_all" href="#"><?= Yii::t('app', 'All styles')?></a></li>
        <?php
        $styles = array();
        foreach ($archsite->petroglyphs as $petroglyph) {
            if (!empty($petroglyph->styles)) {
                foreach ($petroglyph->styles as $style) {
                    if (!isset($styles[$style->name])) {
                        $styles[$style->name]['id'] = $style->id;
                        $styles[$style->name]['count'] = 1;
                    }
                    else $styles[$style->name]['count']++;
                }
            }
        }
        arsort($styles);
        foreach ($styles as $style_name => $style_data){
            ?>
            <li><a href="#" id="style_<?= $style_data['id']?>"><?= $style_name?> (<?= $style_data['count']?>)</a></li>
        <?php } ?>
    </ul>
</div>
    </div>
</div>


<?php

$script = <<< JS

$(document).ready(function () {
    var container = $('.collection');

    container.imagesLoaded(function () {
        container.masonry();
    });
});

function filter(){
    var filter = ".petroglyph-card";
    if ($('#epoch_button').val() != "epoch_all") filter += '.'+$('#epoch_button').val();
    if ($('#culture_button').val() != "culture_all") filter += '.'+$('#culture_button').val();
    if ($('#method_button').val() != "method_all") filter += '.'+$('#method_button').val();
    if ($('#style_button').val() != "style_all") filter += '.'+$('#style_button').val();

    $('.petroglyph-card').hide();
    $(filter).show();
    $('.collection').masonry({transitionDuration: 0});
}

$(document).ready(function() {
    $("#imagetype_dropdown li a").click(
        function () { $('#imagetype_button').html($(this).text() + ' <span class="caret"></span>');
        });
    
    $("#epoch_dropdown li a").click(function () {
         $('#epoch_button').html($(this).text() + ' <span class="caret"></span>');
         $('#epoch_button').val($(this).attr('id'));
         filter()});
    $("#culture_dropdown li a").click(function () {
         $('#culture_button').html($(this).text() + ' <span class="caret"></span>');
         $('#culture_button').val($(this).attr('id'));
         filter()});
    $("#method_dropdown li a").click(function () {
         $('#method_button').html($(this).text() + ' <span class="caret"></span>');
         $('#method_button').val($(this).attr('id'));
         filter()});
    $("#style_dropdown li a").click(function () {
         $('#style_button').html($(this).text() + ' <span class="caret"></span>');
         $('#style_button').val($(this).attr('id'));
         filter()});    
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
    <div class="row collection" id="petroglyph_container">
        <?php foreach ($archsite->petroglyphs as $petroglyph): ?>
            <?php
            $class = "";
            foreach($petroglyph->epochs as $epoch) $class .= " epoch_" . $epoch->id;
            foreach($petroglyph->cultures as $culture) $class .= " culture_" . $culture->id;
            foreach($petroglyph->methods as $method) $class .= " method_" . $method->id;
            foreach($petroglyph->styles as $style) $class .= " style_" . $style->id;
            ?>
            <div class="petroglyph-card <?= $class?> col-xs-12 col-sm-4 col-md-3">
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