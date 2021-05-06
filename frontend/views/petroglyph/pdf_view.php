<?php
use common\models\Petroglyph;
use yii\helpers\Html;

/* @var $petroglyph Petroglyph */

?>

<style>
    body{
        width: 210mm;
    }
    .t_img{
        max-width: 48%;
        vertical-align: top;
    }
    .t2{
        width: 90mm;
    }
</style>
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


<br>
<table style="page-break-inside:avoid;">
    <tr>
        <?php if(!empty($petroglyph->image)):?>
        <td class="t_img">
            <table>
                <tr><td><span style="font-size: 24pt; font-weight: bold"><?= Yii::t('model', 'Image')?></span></td></tr>
                <tr><td><?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImage,['class'=>'pdf_img'])?></td></tr>
            </table>
        </td>
        <?php endif; ?>
        <?php if (!empty($petroglyph->im_dstretch)): ?>
        <td class="t_img">
            <table>
                <tr><td><span style="font-size: 24pt; font-weight: bold"><?= Yii::t('model', 'Image DStretch')?></span></td></tr>
                <tr><td><?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDstretch,['class'=>'pdf_img'])?></td></tr>
            </table>
        </td>
        <?php endif; ?>
    </tr>
    <tr>
    <?php if (!empty($petroglyph->im_drawing)): ?>
        <td class="t_img">
            <table>
                <tr><td><span style="font-size: 24pt; font-weight: bold"><?= Yii::t('model', 'Drawing image')?></span></td></tr>
                <tr><td><?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDrawing,['class'=>'pdf_img'])?></td></tr>
            </table>
        </td>
    <?php endif; ?>
    <?php if (!empty($petroglyph->im_reconstruction)): ?>
        <td class="t_img">
            <table>
                <tr><td><span style="font-size: 24pt; font-weight: bold"><?= Yii::t('model', 'Reconstruction image')?></span></td></tr>
                <tr><td><?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImReconstr,['class'=>'pdf_img'])?></td></tr>
            </table>
        </td>
    <?php endif; ?>
    </tr>
    <tr>
    <?php if (!empty($petroglyph->im_overlay)): ?>
        <td class="t_img">
            <table>
                <tr><td><span style="font-size: 24pt; font-weight: bold"><?= Yii::t('model', 'Image overlay')?></span></td></tr>
                <tr><td><?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImOverlay,['class'=>'pdf_img'])?></td></tr>
            </table>
        </td>
    <?php endif; ?>
    </tr>
</table>
<br>
<table style="page-break-inside: avoid;">
    <tr>
        <td class="t2"><h4><?= Yii::t('app', 'Culture')?></h4></td>
        <td class="t2"><h4><?= Yii::t('app', 'Epoch')?></h4></td>
    </tr>
    <tr>
        <?php $data = [(isset($petroglyph->cultures) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->cultures)) : null)] ?>
        <?php if (!empty($data)): ?>
            <td class="t2">
                <?php foreach ($data as $datum): ?>
                        <?= $datum ?><br>
                <?php endforeach; ?>
            </td>
        <?php endif; ?>
        <?php $data = [(isset($petroglyph->epochs) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->epochs)) : null)] ?>
        <?php if (!empty($data)): ?>
            <td class="t2">
                <?php foreach ($data as $datum): ?>
                    <?= $datum ?><br>
                <?php endforeach; ?>
            </td>
        <?php endif; ?>
    </tr>
    <tr>
        <td class="t2"><h4><?= Yii::t('app', 'Method')?></h4></td>
        <td class="t2"><h4><?= Yii::t('app', 'Style')?></h4></td>
    </tr>
    <tr>
        <?php $data = [(isset($petroglyph->methods) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->methods)) : null)] ?>
        <?php if (!empty($data)): ?>
            <td class="t2">
                <?php foreach ($data as $datum): ?>
                    <?= $datum ?><br>
                <?php endforeach; ?>
            </td>
        <?php endif; ?>
        <?php $data = [(isset($petroglyph->styles) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->styles)) : null)] ?>
        <?php if (!empty($data)): ?>
            <td class="t2">
                <?php foreach ($data as $datum): ?>
                    <?= $datum ?><br>
                <?php endforeach; ?>
            </td>
        <?php endif; ?>
    </tr>
</table>
<br>
<?php if (!empty($petroglyph->publication)): ?>
    <h3 style="page-break-inside: avoid"><?= Yii::t('app', 'Publications') ?></h3>
    <table>
        <tr>
            <td><?= $petroglyph->publication ?></td>
        </tr>
    </table>
<?php endif; ?>