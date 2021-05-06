<?php
use common\models\Petroglyph;
use yii\helpers\Html;

/* @var $petroglyph Petroglyph */
/* @var $image_objects Array */

$line_cnt = intdiv((count($image_objects) + 1), 2);
?>

<style>
    .t_img{
        width: 46%;
    }
    .td_cult{
        width: 50%;
    }
    .tb_img{
        width: 100%;
        page-break-inside: avoid;
        vertical-align: top;
    }
    .td_img_block{
        width: 50%;
        vertical-align: top;
    }
</style>
<h1>
    <?= $petroglyph->name ?>
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
<table>
    <tr>
        <td>
<?php for ($i = 0; $i < $line_cnt; $i++):?>
    <table class="tb_img">
        <tr>
            <?php $image_object = array_shift($image_objects)?>
            <td class="td_img_block">
                <table autosize="1">
                    <tr>
                        <td>
                            <span style="font-size: 12pt; font-weight: bold"><?= $image_object ? $image_object['name'] : '' ?></span>
                        </td>
                    </tr>
                </table>
                <table autosize="1">
                    <tr>
                        <td>
                            <?= $image_object ? Html::img($image_object['image'],['class'=>'t_img']) : '' ?>
                        </td>
                    </tr>
                </table>
            </td>
            <?php $image_object = array_shift($image_objects)?>
            <td class="td_img_block">
                <table autosize="1">
                    <tr>
                        <td>
                            <span style="font-size: 12pt; font-weight: bold"><?= $image_object ? $image_object['name'] : '' ?></span>
                        </td>
                    </tr>
                </table>
                <table autosize="1">
                    <tr>
                        <td>
                            <?= $image_object ? Html::img($image_object['image'],['class'=>'t_img']) : '' ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?php endfor;?>
        </td>
    </tr>
</table>
<br>
<table style="page-break-inside: avoid; width: 100%" autosize="1">
    <tr>
        <td class="td_cult"><h4><?= Yii::t('app', 'Culture')?></h4></td>
        <td class="td_cult"><h4><?= Yii::t('app', 'Epoch')?></h4></td>
    </tr>
    <tr>
        <?php $data = [(isset($petroglyph->cultures) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->cultures)) : null)] ?>
        <?php if (!empty($data)): ?>
            <td class="td_cult">
                <?php foreach ($data as $datum): ?>
                        <?= $datum ?><br>
                <?php endforeach; ?>
            </td>
        <?php endif; ?>
        <?php $data = [(isset($petroglyph->epochs) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->epochs)) : null)] ?>
        <?php if (!empty($data)): ?>
            <td class="td_cult">
                <?php foreach ($data as $datum): ?>
                    <?= $datum ?><br>
                <?php endforeach; ?>
            </td>
        <?php endif; ?>
    </tr>
    <tr>
        <td class="td_cult"><h4><?= Yii::t('app', 'Method')?></h4></td>
        <td class="td_cult"><h4><?= Yii::t('app', 'Style')?></h4></td>
    </tr>
    <tr>
        <?php $data = [(isset($petroglyph->methods) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->methods)) : null)] ?>
        <?php if (!empty($data)): ?>
            <td class="td_cult">
                <?php foreach ($data as $datum): ?>
                    <?= $datum ?><br>
                <?php endforeach; ?>
            </td>
        <?php endif; ?>
        <?php $data = [(isset($petroglyph->styles) ? implode (", ",
            array_map(function($obj) { return $obj->name; }, $petroglyph->styles)) : null)] ?>
        <?php if (!empty($data)): ?>
            <td class="td_cult">
                <?php foreach ($data as $datum): ?>
                    <?= $datum ?><br>
                <?php endforeach; ?>
            </td>
        <?php endif; ?>
    </tr>
</table>
<br>
<?php if (!empty($petroglyph->publication)): ?>
    <table  style="page-break-inside: avoid" autosize="1">
        <tr>
            <td>
                <h3><?= Yii::t('app', 'Publications') ?></h3>
            </td>
        </tr>
        <tr><td></td></tr>
        <tr>
            <td><?= $petroglyph->publication ?></td>
        </tr>
    </table>
<?php endif; ?>