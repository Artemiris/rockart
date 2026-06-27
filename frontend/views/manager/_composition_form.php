<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $petroglyph common\models\Petroglyph */
/* @var $model common\models\Composition */
/* @var $form ActiveForm */
?>
<div class="manager-_petroglyph_form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <?php if(empty($model->id)): ?>
                <?= $form->field($model, 'petroglyph_id')->hiddenInput(['value' => $petroglyph->id])->label(false) ?>
            <?php else: ?>
                <?= $form->field($model, 'petroglyph_id')->hiddenInput()->label(false) ?>
            <?php endif; ?>
            <?= $form->field($model, 'index') ?>
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
            <?= $form->field($model, 'fileImage')->fileInput() ?>

        </div>
        <div class="col-xs-12 col-md-6 text-right">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('manager', 'Save'), ['class' => 'btn btn-primary', 'required' => true]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- manager-_petroglyph_form -->
