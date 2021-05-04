<?php
namespace frontend\controllers;

use common\models\Archsite;
use Yii;
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
        $numPet = $archsite->petroglyphsWithoutAreaCount;
        if ($filter = Yii::$app->request->get('filter')) {
            $petroglyphs = $archsite->searchPetroglyphsWithoutArea(mb_strtoupper($filter))->all();
        }
        else $petroglyphs = $archsite->petroglyphsWithoutArea;
        usort($areas, "\\frontend\\controllers\\ArchsiteController::usortModelsPredicate");
        usort($petroglyphs, "\\frontend\\controllers\\ArchsiteController::usortModelsPredicate");
        return $this->render('view', [
            'archsite' => $archsite,
            'petroglyphs' => $petroglyphs,
            'areas' => $areas,
            'filter' => $filter,
            'numPet' => $numPet
        ]);
    }

    static function usortModelsPredicate($a, $b){
        $a_name = preg_replace(["/(?<!\d)(\d\d)(?!\d)/", "/(?<!\d)(\d)(?!\d)/"], ['0$1','00$1'], $a->name);
        $b_name = preg_replace(["/(?<!\d)(\d\d)(?!\d)/", "/(?<!\d)(\d)(?!\d)/"], ['0$1','00$1'], $b->name);
        return strcmp($a_name, $b_name);
    }
}