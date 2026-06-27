<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $petroglyph common\models\Petroglyph */
/* @var $model common\models\PetroglyphThreeD */
/* @var $form ActiveForm */

$script = <<< JS
        
    $("input[name='PetroglyphThreeD[url]'").bind('input', function(e) {
        $(this).val($($(this).val()).attr('src'));      
    });

JS;

$this->registerJs($script, View::POS_READY);
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
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'name_en') ?>
            <button data-toggle="collapse" data-target="#instruction-3d" type="button" class="btn-link pull-right">Инструкция добавление 3D модели</button>

            <div id="instruction-3d" class="collapse">
                <ol>
                    <li>
                        На сайте <a href="https://3d.nsu.ru" target="_blank">3d.nsu.ru</a> находим нужную модель
                    </li>
                    <li>
                        После загрузки модели жмем на кнопку настройки <img src="/img/3d-setting.png">
                    </li>
                    <li>
                        Развернется спиок инструментов.
                    </li>
                    <li>
                        Жмем на кнопку подделиться <img src="/img/3d-share.png">
                    </li>
                    <li>
                        Появится модальное окно с кодом
                    </li>
                    <li>
                        Нажмите на текст кода
                    </li>
                    <li>
                        Текст кода должен автоматически выделиться и скопироваться в буфер
                    </li>
                    <li>
                        Вставляем скопированный текст кода в поле "3D модель"
                    </li>
                </ol>
            </div>
            <?= $form->field($model, 'url') ?>

        </div>
        <div class="col-xs-12 col-md-6 text-right">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('manager', 'Save'), ['class' => 'btn btn-primary', 'required' => true]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- manager-_petroglyph_form -->
