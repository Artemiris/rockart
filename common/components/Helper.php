<?php


namespace common\components;


use yii\db\ActiveRecord;

class Helper
{
    /**
     * @param $a ActiveRecord
     * @param $b ActiveRecord
     * @return int
     */
    static function usortModelsPredicate($a, $b){
        $a_name = preg_replace(["/([^\d])(\d\d)(?=[^\d]|$)/", "/([^\d])(\d)(?=[^\d]|$)/"], ['${1}0$2$3','${1}00$2$3'], $a->name);
        $b_name = preg_replace(["/([^\d])(\d\d)(?=[^\d]|$)/", "/([^\d])(\d)(?=[^\d]|$)/"], ['${1}0$2$3','${1}00$2$3'], $b->name);
        return strcmp($a_name, $b_name);
    }
}