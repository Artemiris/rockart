<?php


namespace frontend\controllers;

use common\models\Archsite;
use common\models\Area;
use common\utility\PetroglyphPdfUtil;
use Yii;
use yii\helpers\Html;
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

    public function actionPdfView($id){
        $area = Area::findOne($id);
        $petroglyphs = $area->petroglyphs;
        if (empty($area)) {
            throw new HttpException(404);
        }
        usort($petroglyphs, "\\frontend\\controllers\\AreaController::usortModelsPredicate");
        $petroglyphs = array_reverse($petroglyphs);
        $archsiteName = Archsite::find()->where(['id'=>$area->archsite_id])->one()->name;
        $mpdf = new \Mpdf\Mpdf(['format'=>'A4']);
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->SetHTMLHeader('
            <div style="text-align: right;">' .
            Yii::t('app', 'IS Rock art of Siberia') .
            '</div>
            <hr>'
        );
        $mpdf->SetHTMLFooter('
            <hr>
            <table width="100%">
                <tr>
                    <td width="45%">' . Yii::t('app', 'Lab "LIA ARTEMIR"') . '</td>
                    <td width="10%" align="center">{PAGENO}</td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Novosibirsk State University') . '</td>
                </tr>
                <tr>
                    <td width="45%">' . HTML::a('rockart.artemiris.org/area/' . $id,
                'http://rockart.artemiris.org/' . Yii::$app->language . '/area/' . $id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RNF #18-78-10079') . '</td>
                </tr>
            </table>'
        );
        $mpdf->WriteHTML($this->renderPartial('pdf_view',['area'=>$area, 'archsiteName'=>$archsiteName]));

        foreach ($petroglyphs as $petroglyph){
            $pdf_object = PetroglyphPdfUtil::GetPetroglyphPdfObject($petroglyph);
            $mpdf->AddPage();
            $mpdf->SetHTMLFooter('
            <hr>
            <table width="100%">
                <tr>
                    <td width="45%">' . Yii::t('app', 'Lab "LIA ARTEMIR"') . '</td>
                    <td width="10%" align="center">{PAGENO}</td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Novosibirsk State University') . '</td>
                </tr>
                <tr>
                    <td width="45%">' . HTML::a('rockart.artemiris.org/petroglyph/' . $pdf_object['petroglyph']->id,
                    'http://rockart.artemiris.org/' . Yii::$app->language . '/petroglyph/' . $pdf_object['petroglyph']->id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RNF #18-78-10079') . '</td>
                </tr>
            </table>'
            );

            $mpdf->WriteHTML($this->renderPartial('petroglyph_pdf_view', [
                'petroglyph'=>$pdf_object['petroglyph'],
                'image_objects' => $pdf_object['petroglyph_image_objects'],
                'attrib_objects' => $pdf_object['petroglyph_attribute_objects'],
                'parentName' => $archsiteName . '. ' . $area->name . '. '
            ]));
        }

        $mpdf->Output($archsiteName . '. ' . $area->name . '.pdf', 'D');
    }

    static function usortModelsPredicate($a, $b){
        $a_name = preg_replace(["/(?<!\d)(\d\d)(?!\d)/", "/(?<!\d)(\d)(?!\d)/"], ['0$1','00$1'], $a->name);
        $b_name = preg_replace(["/(?<!\d)(\d\d)(?!\d)/", "/(?<!\d)(\d)(?!\d)/"], ['0$1','00$1'], $b->name);
        return strcmp($a_name, $b_name);
    }
}