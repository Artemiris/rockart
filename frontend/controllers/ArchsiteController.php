<?php
namespace frontend\controllers;

use common\models\Archsite;
use yii\web\Controller;
use yii\web\HttpException;


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
        $areas = $archsite->areas;
        $petroglyphs = $archsite->petroglyphsWithoutArea;

        return $this->render('view', [
            'archsite' => $archsite,
            'petroglyphs' => $petroglyphs,
            'areas' => $areas,
        ]);
    }
}