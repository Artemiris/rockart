<?php
use common\models\Petroglyph;
use yii\helpers\Html;

/* @var $petroglyph Petroglyph */
/* @var $image_objects Array */
/* @var $attrib_objects Array */
/* @var $parentName string */

?>

    <style>
        .attr_t_w200{
            width: 200mm;
            page-break-inside: avoid;
            table-layout: fixed;
        }
        .attr_t_w100{
            width: 100mm;
            padding-left: -0.5mm;
        }
        .image_05{
            max-width: 99mm;
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
    <table class="attr_t_w200" autosize="1">
        <?php for ($i = 0; $i < $line_cnt; $i++):?>
            <tr>
                <td class="attr_t_w100">
                    <?php $attrib_object = array_shift($attrib_objects)?>
                    <table>
                        <tr>
                            <td class="attr_t_w100">
                                <h4><?= $attrib_object ? $attrib_object['name'] : '' ?></h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="attr_t_w100">
                                <?= $attrib_object ? $attrib_object['data'] : '' ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="attr_t_w100">
                    <?php $attrib_object = array_shift($attrib_objects)?>
                    <table>
                        <tr>
                            <td class="attr_t_w100">
                                <h4><?= $attrib_object ? $attrib_object['name'] : '' ?></h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="attr_t_w100">
                                <?= $attrib_object ? $attrib_object['data'] : '' ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php endfor;?>
    </table>
<?php endif;?>
<?php $line_cnt = intdiv((count($image_objects) + 1), 2); ?>
<?php if($line_cnt > 0): ?>
    <table class="attr_t_w200" autosize="1">
        <tr>
            <td class="attr_t_w200">
                <?php for ($i = 0; $i < $line_cnt; $i++):?>
                    <table>
                        <tr>
                            <td class="attr_t_w100">
                                <?php $image_object = array_shift($image_objects)?>
                                <?php if(!empty($image_object)):?>
                                    <table>
                                        <tr>
                                            <td class="attr_t_w100">
                                                <h4><?= $image_object['name'] ?></h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="attr_t_w100">
                                                <?= Html::img($image_object['image'],['class'=>'image_05']) ?>
                                            </td>
                                        </tr>
                                    </table>
                                <?php endif; ?>
                            </td>
                            <td class="attr_t_w100">
                                <?php $image_object = array_shift($image_objects)?>
                                <?php if(!empty($image_object)):?>
                                    <table>
                                        <tr>
                                            <td class="attr_t_w100">
                                                <h4><?= $image_object['name'] ?></h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="attr_t_w100">
                                                <?= Html::img($image_object['image'],['class'=>'image_05']) ?>
                                            </td>
                                        </tr>
                                    </table>
                                <?php endif; ?>
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
<div style="page-break-inside: avoid">
    <h3><?= Yii::t('app', 'Publications') ?></h3>
    <?= $petroglyph->publication ?>
</div>
<?php endif; ?>
<?php if(!empty($petroglyph->author_page)):?>
<div>
    <span style="font-size: 14px; font-style: italic"><?= Yii::t('app', 'Description authors') . ': ' . $petroglyph->author_page ?></span>
</div>
<?php endif; ?>
