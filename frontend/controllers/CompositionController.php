<?php
namespace frontend\controllers;

use common\models\Composition;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\HttpException;

/**
 * Class CompositionController
 * @package frontend\controllers
 */
class CompositionController extends BaseController
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $compositions = Composition::find()->all();

        return $this->render('index', [
            'compositions' => $compositions,
        ]);
    }

    public function actionView($id)
    {
        $composition = Composition::findOne($id);

        if (empty($composition)) {
            throw new HttpException(404);
        }

        return $this->render('view', [
            'composition' => $composition,
        ]);
    }
}
