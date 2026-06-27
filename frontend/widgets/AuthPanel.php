<?php

namespace frontend\widgets;

use common\models\LoginForm;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class AuthPanel extends Widget
{
    public function run()
    {
        $model = new LoginForm();

        $form = ActiveForm::begin([
            'id' => 'login-form',
            'action' => ['site/login'],
            'fieldConfig' => [
                'template' => '{input}',
            ]
        ]);

        $fieldUsername = $form->field($model, 'username')->textInput(['placeholder' => \Yii::t('app', 'Login'), 'style' => 'margin-bottom: -15px;'])->label(false);
        $fieldPassword = $form->field($model, 'password')->passwordInput(['placeholder' => \Yii::t('app', 'Password'), 'style' => 'margin-bottom: -15px'])->label(false);
        $btn = Html::submitButton(\Yii::t('app', 'Sign in'), ['class' => 'btn btn-primary', 'name' => 'login-button']);

        $row = Html::tag('div', $fieldUsername . '&nbsp;' . $fieldPassword  . '&nbsp;' . $btn, [
            'style' => 'display: flex; justify-content: space-between; align-items: flex-end; margin-top: 10px;',
            'class' => 'hidden-xs'
        ]);

        $link = Html::a(\Yii::t('app', 'Sign in'), ['site/login'], ['class' => 'btn btn-primary visible-xs']);

        echo $row;
        echo $link;

        ActiveForm::end();
    }

}