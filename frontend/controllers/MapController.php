<?php
namespace frontend\controllers;

use common\models\Petroglyph;
use Yii;
use yii\filters\AccessControl;

/**
 * Class MapController
 * @package frontend\controllers
 */
class MapController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $query = null;

        if ($filter = Yii::$app->request->get('filter'))
            $query = Petroglyph::morphySearch(mb_strtoupper($filter));
        else{
            $query = Petroglyph::find()->where(['deleted' => null]);
            if (!Yii::$app->user->can('manager')) $query->andWhere(['public' => 1]);
        }

        $petroglyphs = $query->andWhere(['not', ['lat' => null]])->andWhere(['not', ['lng' => null]])->all();
        $array_petroglyphs = [];

        if (!empty($petroglyphs)) {
            foreach ($petroglyphs as $petroglyph) {
                $epochs = [];
                foreach ($petroglyph->epochs as $epoch) 
                    $epochs[] = $epoch->id;
                $cultures = [];
                foreach ($petroglyph->cultures as $culture)
                    $cultures[] = $culture->id;
                $methods = [];
                foreach ($petroglyph->methods as $method)
                    $methods[] = $method->id;
                $styles = [];
                foreach ($petroglyph->styles as $style)
                    $styles[] = $style->id;

                $array_petroglyphs[] = [
                    'id' => $petroglyph->id,
                    'name' => $petroglyph->name,
                    'lat' => $petroglyph->lat,
                    'lng' => $petroglyph->lng,
                    'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImage,
                    'im_dstretch' => !empty($petroglyph->im_dstretch)?Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDstretch : "",
                    'im_drawing' => !empty($petroglyph->im_drawing)?Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDrawing : "",
                    'im_reconstruction' => !empty($petroglyph->im_reconstruction)?Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImReconstr : "",
                    'im_overlay' => !empty($petroglyph->im_overlay)?Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImOverlay : "",
                    'epochs' => $epochs,
                    'cultures' => $cultures,
                    'methods' => $methods,
                    'styles' => $styles,
                ];
            }
        }
        $json_petroglyphs = json_encode($array_petroglyphs, JSON_UNESCAPED_UNICODE);

        $mapProvider = Yii::$app->request->get('mapProvider') == 'yandex' ? 'yandex' : 'google';

        return $this->render('index', [
            'petroglyphs' => $petroglyphs,
            'json_petroglyphs' => $json_petroglyphs,
            'mapProvider' => $mapProvider,
            'filter' => $filter,
        ]);
    }
}
