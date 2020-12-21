<?php


namespace frontend\controllers;

use common\models\Area;
use common\models\Petroglyph;

class AreaController extends \yii\web\Controller
{
    public function actionView($id)
    {
        $area = Area::findOne($id);

        if (empty($area)) {
            throw new HttpException(404);
        }
        $petroglyphs = $area->petroglyphs;

        return $this->render('view', [
            'area' => $area,
            'petroglyphs' => $petroglyphs,
        ]);
    }
}