<?php
use common\models\Petroglyph;
use yii\helpers\Html;

/* @var $petroglyph Petroglyph */

?>

<style>
    .pdf_img{
        max-width: 45%;
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
<?php if (!empty($petroglyph->publication)): ?>
    <h3><?= Yii::t('app', 'Publications') ?></h3>
    <?= $petroglyph->publication ?>
<?php endif; ?>

<br>
<table style="width: 100%; page-break-inside:avoid;">
    <tr>
        <?php if(!empty($petroglyph->image)):?>
        <td style="width: 50%">
            <div style="width: 50%"><?= Yii::t('model', 'Image')?></div>
            <br>
            <?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImage,['class'=>'pdf_img'])?>
            <br>
        </td>
        <?php endif; ?>
        <?php if (!empty($petroglyph->im_dstretch)): ?>
        <td style="width: 50%">
            <div style="width: 50%"><?= Yii::t('model', 'Image DStretch')?></div>
            <br>
            <?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDstretch,['class'=>'pdf_img'])?>
            <br>
        </td>
        <?php endif; ?>
    </tr>
    <tr>
    <?php if (!empty($petroglyph->im_drawing)): ?>
        <td style="width: 50%">
            <div style="width: 50%"><?= Yii::t('model', 'Drawing image')?></div>
            <br>
            <?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDrawing,['class'=>'pdf_img'])?>
            <br>
        </td>
    <?php endif; ?>
    <?php if (!empty($petroglyph->im_reconstruction)): ?>
        <td style="width: 50%">
            <div style="width: 50%"><?= Yii::t('model', 'Reconstruction image')?></div>
            <br>
            <?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImReconstr,['class'=>'pdf_img'])?>
            <br>
        </td>
    <?php endif; ?>
    </tr>
    <tr>
    <?php if (!empty($petroglyph->im_overlay)): ?>
        <td style="width: 50%">
            <div style="width: 50%"><?= Yii::t('model', 'Image overlay')?></div>
            <br>
            <?= Html::img(Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImOverlay,['class'=>'pdf_img'])?>
            <br>
        </td>
    <?php endif; ?>
    </tr>
</table>
<?php if (!empty($petroglyph->cultures)):?>
    <?= $this->render('_panel', [
        'title' => Yii::t('app', 'Culture'),
        'data' => [(isset($petroglyph->cultures) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->cultures)) : null)],
    ]) ?>
<?php endif; ?>
<?php if (!empty($petroglyph->epochs)):?>
    <?= $this->render('_panel', [
        'title' => Yii::t('app', 'Epoch'),
        'data' => [(isset($petroglyph->epochs) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->epochs)) : null)],
    ]) ?>
<?php endif; ?>
<?php if (!empty($petroglyph->methods)):?>
    <?= $this->render('_panel', [
        'title' => Yii::t('app', 'Method'),
        'data' => [(isset($petroglyph->methods) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->methods)) : null)],
    ]) ?>
<?php endif; ?>
<?php if (!empty($petroglyph->styles)):?>
    <?= $this->render('_panel', [
        'title' => Yii::t('app', 'Style'),
        'data' => [(isset($petroglyph->styles) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->styles)) : null)],
    ]) ?>
<?php endif; ?>