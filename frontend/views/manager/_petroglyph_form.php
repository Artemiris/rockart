<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Petroglyph */
/* @var $form ActiveForm */
/* @var $areas Array */
?>
<div class="manager-_petroglyph_form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'archsite_id')->dropDownList($archsites, ['prompt'=>Yii::t('manager', 'Select...')]) ?>
            <?php if (!empty($areas)): ?>
            <?= $form->field($model, 'area_id')->dropDownList($areas, ['prompt'=>Yii::t('manager', 'Select...')]) ?>
            <?php endif; ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'name_en') ?>
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
            <?= $form->field($model, 'lat') ?>
            <?= $form->field($model, 'lng') ?>
            <?= $form->field($model, 'culture_ids')->listBox($cultures, ['multiple' => true]) ?>
            <?= $form->field($model, 'epoch_ids')->listBox($epochs, ['multiple' => true]) ?>
            <?= $form->field($model, 'method_ids')->listBox($methods, ['multiple' => true]) ?>
            <?= $form->field($model, 'style_ids')->listBox($styles, ['multiple' => true]) ?>
            <?= $form->field($model, 'public')->checkbox() ?>
            <?= $form->field($model, 'fileImage')->fileInput(), 
                $form->field($model, 'fileDstr')->fileInput(),
                $form->field($model, 'fileDraw')->fileInput(),
                $form->field($model, 'fileReconstr')->fileInput(),
                $form->field($model, 'fileOverlay')->fileInput() ?>
            <?= $form->field($model, 'index') ?>
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
        <div class="col-xs-12 col-md-6 text-right">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('manager', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- manager-_petroglyph_form -->