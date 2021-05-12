<?php
use common\models\Petroglyph;
use yii\helpers\Html;

/* @var $petroglyph Petroglyph */
/* @var $image_objects Array */
/* @var $attrib_objects Array */
/* @var $parentName string */

?>

    <style>
        .t_img{
            width: 46%;
        }
        .td_cult{
            width: 50%;
        }
        span.head{
            font-size: 14pt;
            font-weight: bold;
        }
        span.body{
            font-size: 14pt;
        }
        .tb_out{
            padding-left: -1mm;
        }
        .td_a{
            font-size: 8pt;
        }
        .tb_img{
            width: 100%;
            vertical-align: top;
        }
        .tb_att{
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
        <?= empty($parentName) ? $petroglyph->name : $parentName . $petroglyph->name ?>
    </h1>
<?php if(!empty($image_objects)):?>
<?php $image_main = array_shift($image_objects) ?>
<?= Html::img($image_main['image']) ?>
<?php endif; ?>
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
<?php $line_cnt = intdiv((count($attrib_objects) + 1), 2); ?>
<?php if($line_cnt > 0): ?>
    <br>
    <table class="tb_att" style="width: 210mm" autosize="1">
        <tr>
            <td>
                <?php for ($i = 0; $i < $line_cnt; $i++):?>
                    <table class="tb_img" style="width: 210mm" autosize="1">
                        <tr>
                            <?php $attrib_object = array_shift($attrib_objects)?>
                            <td class="td_img_block tb_out">
                                <table autosize="1">
                                    <tr>
                                        <td class="tb_out">
                                            <span class="head"><?= $attrib_object ? $attrib_object['name'] : '' ?></span>
                                        </td>
                                    </tr>
                                </table>
                                <table autosize="1">
                                    <tr>
                                        <td class="tb_out">
                                            <span class="body"><?= $attrib_object ? $attrib_object['data'] : '' ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <?php $attrib_object = array_shift($attrib_objects)?>
                            <td class="td_img_block">
                                <table autosize="1">
                                    <tr>
                                        <td>
                                            <span class="head"><?= $attrib_object ? $attrib_object['name'] : '' ?></span>
                                        </td>
                                    </tr>
                                </table>
                                <table autosize="1">
                                    <tr>
                                        <td>
                                            <span class="body"><?= $attrib_object ? $attrib_object['data'] : '' ?></span>
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
<?php endif;?>
<?php $line_cnt = intdiv((count($image_objects) + 1), 2); ?>
<?php if($line_cnt > 0): ?>
    <table style="width: 210mm; table-layout: fixed">
        <tr>
            <td>
                <?php for ($i = 0; $i < $line_cnt; $i++):?>
                    <table class="tb_img">
                        <tr>
                            <?php $image_object = array_shift($image_objects)?>
                            <td class="td_img_block tb_out">
                                <table autosize="1">
                                    <tr>
                                        <td class="tb_out">
                                            <span class="head"><?= $image_object ? $image_object['name'] : '' ?></span>
                                        </td>
                                    </tr>
                                </table>
                                <table autosize="1">
                                    <tr>
                                        <td class="tb_out">
                                            <?= $image_object ? Html::img($image_object['image'],['class'=>'t_img']) : '' ?>
                                        </td>
                                    </tr>
                                </table>
                                <table autosize="1">
                                    <tr>
                                        <td class="td_a tb_out">
                                            <?= $image_object && $image_object['author'] ? Yii::t('model','Image authors') . ': ' . $image_object['author'] . '<br>' : '' ?>
                                            <?= $image_object && $image_object['copyright'] ? Yii::t('model','Image copyright') . ': ' . $image_object['copyright'] . '<br>' : '' ?>
                                            <?= $image_object && $image_object['source'] ? Yii::t('model','Image source') . ': ' . $image_object['source'] : '' ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <?php $image_object = array_shift($image_objects)?>
                            <td class="td_img_block">
                                <table autosize="1">
                                    <tr>
                                        <td>
                                            <span class="head"><?= $image_object ? $image_object['name'] : '' ?></span>
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
                                <table autosize="1">
                                    <tr>
                                        <td class="td_a">
                                            <?= $image_object && $image_object['author'] ? Yii::t('model','Image authors') . ': ' . $image_object['author'] . '<br>' : '' ?>
                                            <?= $image_object && $image_object['copyright'] ? Yii::t('model','Image copyright') . ': ' . $image_object['copyright'] . '<br>' : '' ?>
                                            <?= $image_object && $image_object['source'] ? Yii::t('model','Image source') . ': ' . $image_object['source'] : '' ?>
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
<?php endif; ?>
<?php if (!empty($petroglyph->publication)): ?>
    <br>
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