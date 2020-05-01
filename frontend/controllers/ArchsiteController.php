<?php
namespace frontend\controllers;

use common\models\Archsite;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;


/**
 * Class ArchsiteController
 * @package frontend\controllers
 */
class ArchsiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $archsites = Archsite::find()->all();

        return $this->render('index', [
            'archsites' => $archsites,
        ]);
    }

    public function actionView($id)
    {
       $archsite = Archsite::findOne($id);

        if (empty($archsite)) {
            throw new HttpException(404);
        }
        $petroglyphs = null;

        if ($filter = Yii::$app->request->get('filter')) {
            $petroglyphs = $archsite->searchPetroglyphs(mb_strtoupper($filter))->all();
        }
        else $petroglyphs = $archsite->petroglyphs;

        return $this->render('view', [
            'archsite' => $archsite,
            'petroglyphs' => $petroglyphs,
            'filter' => $filter
        ]);
    }
}
