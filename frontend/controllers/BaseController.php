<?php

namespace frontend\controllers;

use common\models\Counter;
use Yii;
use yii\web\Controller;

/**
 * Class BaseController
 * @package frontend\controllers
 */
class BaseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        self::openGraph();
        self::metric();

        return parent::beforeAction($action);
    }

    /**
     * @param array $params
     * @throws \yii\base\InvalidConfigException
     */
    protected function openGraph($params = []){
        Yii::$app->opengraph->title = isset($params['title']) ? $params['title'] : Yii::t('home', 'Rock art of Siberia');
        Yii::$app->opengraph->description = isset($params['description']) ? $params['description'] : Yii::t('home', 'Information system of Siberian rock art');
        Yii::$app->opengraph->image = Yii::$app->urlManager->getHostInfo() . (isset($params['image']) ? $params['image'] : '/img/opengraph.png');
    }

    protected function metric()
    {
        $model = new Counter();
        $model->ip = (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"]);
        $model->uri = $_SERVER["REQUEST_URI"];
        $model->user_agent = $_SERVER["HTTP_USER_AGENT"];
        $model->save();
    }

    static function usortAreasPredicate($a,$b){
        $a_name = $a->name;
        $a_name = preg_replace_callback("/\d+/", "\\frontend\\controllers\\BaseController::addZero", $a_name);
        $b_name = $b->name;
        $b_name = preg_replace_callback("/\d+/", "\\frontend\\controllers\\BaseController::addZero", $b_name);
        return strcmp($a_name, $b_name);
    }

    static function addZero($matches){
        $len = strlen($matches[0]);
        if($len == 1){
            $res = '00' . $matches[0];
        } elseif ($len == 2){
            $res = '0' . $matches[0];
        } else {
            $res = $matches[0];
        }

        return $res;
    }
}
