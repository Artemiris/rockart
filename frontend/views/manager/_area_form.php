<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use common\models\Area;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form ActiveForm */
/* @var $archsites Array*/
?>
<div class="manager-_archsite_form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-6">
        <?= $form->field($model, 'archsite_id')->dropDownList($archsites, ['prompt'=>Yii::t('manager', 'Select...')]) ?>
        </div>
    </div>
    <div class="row">

        <div class="clearfix"></div>

        <div class="col-xs-6">
            <?= $form->field($model, 'name')->textInput() ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'name_en')->textInput() ?>
        </div>

        <div class="clearfix"></div>

        <div class="col-xs-6">
            <?= $form->field($model, 'description')->widget(CKEditor::class,
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
            <?= $form->field($model, 'description_en')->widget(CKEditor::class,
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

        <div class="clearfix"></div>
        <div class="col-xs-3">
            <?= $form->field($model, 'lat')->textInput() ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model, 'lng')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
