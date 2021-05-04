<?php


namespace frontend\controllers;

use common\models\Area;
use Yii;
use yii\web\HttpException;

class AreaController extends \yii\web\Controller
{
    public function actionView($id)
    {
        $area = Area::findOne($id);

        if (empty($area)) {
            throw new HttpException(404);
        }
        if ($filter = Yii::$app->request->get('filter')) {
            $petroglyphs = $area->searchPetroglyphs(mb_strtoupper($filter))->all();
        }
        else $petroglyphs = $area->petroglyphs;
        usort($petroglyphs, "\\frontend\\controllers\\AreaController::usortModelsPredicate");
        return $this->render('view', [
            'area' => $area,
            'petroglyphs' => $petroglyphs,
            'filter' => $filter
        ]);
    }

    static function usortModelsPredicate($a, $b){
        $a_name = preg_replace(["/(?<!\d)(\d\d)(?!\d)/", "/(?<!\d)(\d)(?!\d)/"], ['0$1','00$1'], $a->name);
        $b_name = preg_replace(["/(?<!\d)(\d\d)(?!\d)/", "/(?<!\d)(\d)(?!\d)/"], ['0$1','00$1'], $b->name);
        return strcmp($a_name, $b_name);
    }
}