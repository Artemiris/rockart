<?php


namespace console\controllers;


use common\models\Petroglyph;
use common\models\PetroglyphThreeD;
use yii\db\Exception;
use yii\db\Query;

class CliController extends \yii\console\Controller
{
    public function actionFill3d($file)
    {
        \Yii::$app->language = 'ru';
        $fileRecords = json_decode(file_get_contents(\Yii::getAlias('@console') . '/../' . $file));
        if(empty($fileRecords))
            throw new \Exception('File ' . $file . ' not found or empty');

        $count = 0;
        $result_str = '';

        foreach (Petroglyph::find()->multilingual()->each() as $petroglyph)
        {
            $archsite = (new Query)->select('name')->from('archsite_language')->where(['archsite_id'=>$petroglyph->archsite_id])->andWhere(['locale'=>'ru'])->one();
            if(is_array($archsite))
            {
                $archsite_name = $archsite['name'];
            }
            else
            {
                $archsite_name = $archsite;
            }
            $area = (new Query)->select('name')->from('area_language')->where(['area_id'=>$petroglyph->area_id])->andWhere(['locale'=>'ru'])->one();
            if(is_array($area))
            {
                $area_name = $area['name'];
            }
            else
            {
                $area_name = $area;
            }
            $actualName = $petroglyph->name;
            if($area_name)
            {
                $actualName = str_replace($area_name . ". ",'',$petroglyph->name);
            }
            $fullName = ($archsite_name ? $archsite_name . ". " : "") . ($area_name ? $area_name . ". " : "") . $actualName;
            foreach ($fileRecords as $fileRecord) {
                if ($fullName == $fileRecord->name && empty($petroglyph->threeD)) {
                    $p3d = new PetroglyphThreeD();
                    $p3d->url = "https://3d.nsu.ru/ru/iframe/" . $fileRecord->object_id;
                    $p3d->petroglyph_id = $petroglyph->id;
                    $p3d->name = is_array($petroglyph->name) ? $petroglyph->name[0] : $petroglyph->name;
                    $p3d->name_en = is_array($petroglyph->name_en) ? $petroglyph->name_en[0] : $petroglyph->name_en;

                    if ($p3d->save()) {
                        $count++;
                        $result_str .= "<p>" . $fullName . "...WRITTEN</p>\n";
                    } else {
                        file_put_contents('err.txt', json_encode($p3d->errors));
                        $result_str .= "<p>" . $fullName . "...ERROR</p>\n";
                        $result_str .= "<p>" . print_r($p3d->errors, true) . "</p>";
                    }
                }
            }
        }
        $result_str .= "<p>Произведено вставок: " . $count . "</p>\n";
        file_put_contents('fill_result.txt', $result_str);
    }
}