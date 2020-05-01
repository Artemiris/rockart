<?php

use yii\widgets\ActiveForm;

?>

<div class="container-fluid">
    <div class="row form-group">
        <form method='get'>
            <?php if (isset($hiddens)) echo $hiddens?>
        <div class="btn-group">
            <button id="imagetype_button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <?= Yii::t('manager', 'View original images') ?> <span class="caret"></span>
            </button>
            <ul id="imagetype_dropdown" class="dropdown-menu">
                <?php foreach ($petroglyphs as $petroglyph): ?>
                    <?php if (!empty($petroglyph->image)): ?>
                        <li><a href="#" id="vieworigin"><?= Yii::t('app', 'View original images') ?></a></li>
                        <?php break; endif; ?>
                <?php endforeach; ?>
                <?php foreach ($petroglyphs as $petroglyph): ?>
                    <?php if (!empty($petroglyph->im_dstretch)): ?>
                        <li><a href="#" id="viewdstretch"><?= Yii::t('app', 'View images DStretch') ?></a></li>
                        <?php break; endif; ?>
                <?php endforeach; ?>
                <?php foreach ($petroglyphs as $petroglyph): ?>
                    <?php if (!empty($petroglyph->im_drawing)): ?>
                        <li><a href="#" id="viewdrawing"><?= Yii::t('app', 'View drawing') ?></a></li>
                        <?php break; endif; ?>
                <?php endforeach; ?>
                <?php foreach ($petroglyphs as $petroglyph): ?>
                    <?php if (!empty($petroglyph->im_reconstruction)): ?>
                        <li><a href="#" id="viewreconstruction"><?= Yii::t('app', 'View reconstruction') ?></a></li>
                        <?php break; endif; ?>
                <?php endforeach; ?>
                <?php foreach ($petroglyphs as $petroglyph): ?>
                    <?php if (!empty($petroglyph->im_overlay)): ?>
                        <li><a href="#" id="viewoverlay"><?= Yii::t('app', 'View overlay images') ?></a></li>
                        <?php break; endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="btn-group">
            <button id="epoch_button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" value="epoch_all">
                <?= Yii::t('app', 'All epochs') ?> <span class="caret"></span>
            </button>
            <ul id="epoch_dropdown" class="dropdown-menu">
                <li><a id="epoch_all" href="#"><?= Yii::t('app', 'All epochs') ?></a></li>
                <?php
                $epochs = array();
                foreach ($petroglyphs as $petroglyph) {
                    if (!empty($petroglyph->epochs)) {
                        foreach ($petroglyph->epochs as $epoch) {
                            if (!isset($epochs[$epoch->name])) {
                                $epochs[$epoch->name]['id'] = $epoch->id;
                                $epochs[$epoch->name]['count'] = 1;
                            } else $epochs[$epoch->name]['count']++;
                        }
                    }
                }
                arsort($epochs);
                foreach ($epochs as $epoch_name => $epoch_data) {
                    ?>
                    <li><a href="#" id="epoch_<?= $epoch_data['id'] ?>"><?= $epoch_name ?> (<?= $epoch_data['count'] ?>
                            )</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="btn-group">
            <button id="culture_button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" value="culture_all">
                <?= Yii::t('app', 'All cultures') ?> <span class="caret"></span>
            </button>
            <ul id="culture_dropdown" class="dropdown-menu">
                <li><a id="culture_all" href="#"><?= Yii::t('app', 'All cultures') ?></a></li>
                <?php
                $cultures = array();
                foreach ($petroglyphs as $petroglyph) {
                    if (!empty($petroglyph->cultures)) {
                        foreach ($petroglyph->cultures as $culture) {
                            if (!isset($cultures[$culture->name])) {
                                $cultures[$culture->name]['id'] = $culture->id;
                                $cultures[$culture->name]['count'] = 1;
                            } else $cultures[$culture->name]['count']++;
                        }
                    }
                }
                arsort($cultures);
                foreach ($cultures as $culture_name => $culture_data) {
                    ?>
                    <li><a href="#" id="culture_<?= $culture_data['id'] ?>"><?= $culture_name ?>
                            (<?= $culture_data['count'] ?>)</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="btn-group">
            <button id="method_button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" value="method_all">
                <?= Yii::t('app', 'All methods') ?> <span class="caret"></span>
            </button>
            <ul id="method_dropdown" class="dropdown-menu">
                <li><a id="method_all" href="#"><?= Yii::t('app', 'All methods') ?></a></li>
                <?php
                $methods = array();
                foreach ($petroglyphs as $petroglyph) {
                    if (!empty($petroglyph->methods)) {
                        foreach ($petroglyph->methods as $method) {
                            if (!isset($methods[$method->name])) {
                                $methods[$method->name]['id'] = $method->id;
                                $methods[$method->name]['count'] = 1;
                            } else $methods[$method->name]['count']++;
                        }
                    }
                }
                arsort($methods);
                foreach ($methods as $method_name => $method_data) {
                    ?>
                    <li><a href="#" id="method_<?= $method_data['id'] ?>"><?= $method_name ?>
                            (<?= $method_data['count'] ?>)</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="btn-group">
            <button id="style_button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" value="style_all">
                <?= Yii::t('app', 'All styles') ?> <span class="caret"></span>
            </button>
            <ul id="style_dropdown" class="dropdown-menu">
                <li><a id="style_all" href="#"><?= Yii::t('app', 'All styles') ?></a></li>
                <?php
                $styles = array();
                foreach ($petroglyphs as $petroglyph) {
                    if (!empty($petroglyph->styles)) {
                        foreach ($petroglyph->styles as $style) {
                            if (!isset($styles[$style->name])) {
                                $styles[$style->name]['id'] = $style->id;
                                $styles[$style->name]['count'] = 1;
                            } else $styles[$style->name]['count']++;
                        }
                    }
                }
                arsort($styles);
                foreach ($styles as $style_name => $style_data) {
                    ?>
                    <li><a href="#" id="style_<?= $style_data['id'] ?>"><?= $style_name ?> (<?= $style_data['count'] ?>
                            )</a></li>
                <?php } ?>
            </ul>
        </div>
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