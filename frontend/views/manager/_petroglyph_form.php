<?php

use common\models\Archsite;
use common\models\Area;
use common\models\Culture;
use common\models\Epoch;
use common\models\Method;
use common\models\Style;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Petroglyph */
/* @var $form ActiveForm */
/* @var $areas Area[] */
/* @var $archsites Archsite[] */
/* @var $cultures Culture[] */
/* @var $epochs Epoch[] */
/* @var $methods Method[] */
/* @var $styles Style[] */
?>
<div class="manager-_petroglyph_form">

    <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-xs-6"><?= $form->field($model, 'archsite_id')->dropDownList($archsites, ['prompt'=>Yii::t('manager', 'Select...'),
                    'onchange'=>'
                        $.post("'.Url::toRoute('manager/area-list').'",
                        {id : $(this).val()},
                        function(data){
                            $("select#petroglyph-area_id").html(data).attr("disabled",false);
                        }
                        );']) ?>
                </div>
                <div class="col-xs-3"><?= $form->field($model, 'public')->checkbox() ?></div>
                <div class="col-xs-3">
                    <?= Html::submitButton(Yii::t('manager', 'Save'), ['class' => 'btn btn-primary pull-right']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?php if(!empty($areas)):?>
                    <?= $form->field($model, 'area_id')->dropDownList($areas, ['prompt'=>Yii::t('manager', 'Select...')]) ?>
                    <?php else:?>
                    <?= $form->field($model, 'area_id')->dropDownList($areas, ['prompt'=>Yii::t('manager', 'No areas on this site')]) ?>
                    <?php endif;?>
                </div>
                <div class="col-xs-6"><?= $form->field($model, 'index') ?></div>
            </div>
            <div class="row">
                <div class="col-xs-6"><?= $form->field($model, 'name') ?></div>
                <div class="col-xs-6"><?= $form->field($model, 'name_en') ?></div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= $form->field($model, 'description')->widget(CKEditor::className(),
                        [
                            'editorOptions' => [
                                'preset' => 'standard',
                                'inline' => false,
                            ],
                            'options' => [
                                'allowedContent' => true,
                            ],

                        ]) ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($model, 'description_en')->widget(CKEditor::className(),
                        [
                            'editorOptions' => [
                                'preset' => 'standard',
                                'inline' => false,
                            ],
                            'options' => [
                                'allowedContent' => true,
                            ],

                        ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6"><?= $form->field($model, 'lat') ?></div>
                <div class="col-xs-6"><?= $form->field($model, 'lng') ?></div>
            </div>
            <div class="row">
                <div class="col-xs-6"><?= $form->field($model, 'culture_ids')->listBox($cultures, ['multiple' => true]) ?></div>
                <div class="col-xs-6"><?= $form->field($model, 'epoch_ids')->listBox($epochs, ['multiple' => true]) ?></div>
            </div>
            <div class="row">
                <div class="col-xs-6"><?= $form->field($model, 'method_ids')->listBox($methods, ['multiple' => true]) ?></div>
                <div class="col-xs-6"><?= $form->field($model, 'style_ids')->listBox($styles, ['multiple' => true]) ?></div>
            </div>
    <br>
    <hr>
            <div class="row">
                <div class="col-xs-12"><?= $form->field($model, 'fileImage')->fileInput()?></div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::img(\common\models\Petroglyph::SRC_IMAGE.'/'.$model->thumbnailImage,[
                            'class' => 'img-thumbnail'
                        ])?>
                </div>
                <div class="col-xs-6 img-data-edit">
                    <?= $form->field($model, 'img_author')->textInput() ?>
                    <?= $form->field($model, 'img_author_en')->textInput() ?>
                    <?= $form->field($model, 'img_copyright')->textInput() ?>
                    <?= $form->field($model, 'img_copyright_en')->textInput() ?>
                    <?= $form->field($model, 'img_source')->textInput() ?>
                    <?= $form->field($model, 'img_source_en')->textInput() ?>
                </div>
            </div>
    <hr>
    <br>
            <div class="row">
                <div class="col-xs-6"><?=$form->field($model, 'fileDstr')->fileInput()?></div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::img(\common\models\Petroglyph::SRC_IMAGE.'/'.$model->thumbnailImDstretch,[
                        'class' => 'img-thumbnail'
                    ])?>
                </div>
                <div class="col-xs-6 img-data-edit">
                    <?= $form->field($model, 'ds_img_author')->textInput() ?>
                    <?= $form->field($model, 'ds_img_author_en')->textInput() ?>
                    <?= $form->field($model, 'ds_img_copyright')->textInput() ?>
                    <?= $form->field($model, 'ds_img_copyright_en')->textInput() ?>
                    <?= $form->field($model, 'ds_img_source')->textInput() ?>
                    <?= $form->field($model, 'ds_img_source_en')->textInput() ?>
                </div>
            </div>
    <hr>
    <br>
            <div class="row">
                <div class="col-xs-6">
                    <?=$form->field($model, 'fileDraw')->fileInput()?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::img(\common\models\Petroglyph::SRC_IMAGE.'/'.$model->thumbnailImDrawing,[
                        'class' => 'img-thumbnail'
                    ])?>
                </div>
                <div class="col-xs-6 img-data-edit">
                    <?= $form->field($model, 'dr_img_author')->textInput() ?>
                    <?= $form->field($model, 'dr_img_author_en')->textInput() ?>
                    <?= $form->field($model, 'dr_img_copyright')->textInput() ?>
                    <?= $form->field($model, 'dr_img_copyright_en')->textInput() ?>
                    <?= $form->field($model, 'dr_img_source')->textInput() ?>
                    <?= $form->field($model, 'dr_img_source_en')->textInput() ?>
                </div>
            </div>
    <hr>
    <br>
            <div class="row">
                <div class="col-xs-6">
                    <?=$form->field($model, 'fileReconstr')->fileInput()?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::img(\common\models\Petroglyph::SRC_IMAGE.'/'.$model->thumbnailImReconstr,[
                        'class' => 'img-thumbnail'
                    ])?>
                </div>
                <div class="col-xs-6 img-data-edit">
                    <?= $form->field($model, 're_img_author')->textInput() ?>
                    <?= $form->field($model, 're_img_author_en')->textInput() ?>
                    <?= $form->field($model, 're_img_copyright')->textInput() ?>
                    <?= $form->field($model, 're_img_copyright_en')->textInput() ?>
                    <?= $form->field($model, 're_img_source')->textInput() ?>
                    <?= $form->field($model, 're_img_source_en')->textInput() ?>
                </div>
            </div>
    <hr>
    <br>
            <div class="row">
                <div class="col-xs-6">
                    <?=$form->field($model, 'fileOverlay')->fileInput()?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::img(\common\models\Petroglyph::SRC_IMAGE.'/'.$model->thumbnailImOverlay,[
                        'class' => 'img-thumbnail'
                    ])?>
                </div>
                <div class="col-xs-6 img-data-edit">
                    <?= $form->field($model, 'ov_img_author')->textInput() ?>
                    <?= $form->field($model, 'ov_img_author_en')->textInput() ?>
                    <?= $form->field($model, 'ov_img_copyright')->textInput() ?>
                    <?= $form->field($model, 'ov_img_copyright_en')->textInput() ?>
                    <?= $form->field($model, 'ov_img_source')->textInput() ?>
                    <?= $form->field($model, 'ov_img_source_en')->textInput() ?>
                </div>
            </div>
    <hr>
    <br>
            <div class="row">
                <div class="col-xs-6">
                    <?= $form->field($model, 'technical_description')->widget(CKEditor::className(),
                        [
                            'editorOptions' => [
                                'preset' => 'standard',
                                'inline' => false,
                            ],
                            'options' => [
                                'allowedContent' => true,
                            ],

                        ]) ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($model, 'technical_description_en')->widget(CKEditor::className(),
                        [
                            'editorOptions' => [
                                'preset' => 'standard',
                                'inline' => false,
                            ],
                            'options' => [
                                'allowedContent' => true,
                            ],

                        ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= $form->field($model, 'publication')->widget(CKEditor::className(),
                        [
                            'editorOptions' => [
                                'preset' => 'standard',
                                'inline' => false,
                            ],
                            'options' => [
                                'allowedContent' => true,
                            ],

                        ]) ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($model, 'publication_en')->widget(CKEditor::className(),
                        [
                            'editorOptions' => [
                                'preset' => 'standard',
                                'inline' => false,
                            ],
                            'options' => [
                                'allowedContent' => true,
                            ],

                        ]) ?>
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-6"><?= $form->field($model, 'author_page') ?></div>
                    <div class="col-xs-6"><?= $form->field($model, 'author_page_en') ?></div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
<!-- manager-_petroglyph_form -->
