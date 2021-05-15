<?php
namespace frontend\controllers;

use common\models\Archsite;
use common\models\Area;
use common\utility\PetroglyphPdfUtil;
use phpDocumentor\Reflection\Types\This;
use Yii;
use yii\helpers\Html;
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

    public function actionPdfView($id){
        $archsite = Archsite::findOne($id);

        if (empty($archsite)) {
            throw new HttpException(404);
        }
        $areas = $archsite->areas;
        $withoutArea = $archsite->petroglyphsWithoutArea;
        usort($areas, "\\frontend\\controllers\\ArchsiteController::usortModelsPredicate");
        usort($withoutArea, "\\frontend\\controllers\\ArchsiteController::usortModelsPredicate");

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
                    <td width="45%">' . Yii::t('app', 'Prehistoric Art in Eurasia Lab') . '</td>
                    <td width="10%" align="center">{PAGENO}</td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Novosibirsk State University') . '</td>
                </tr>
                <tr>
                    <td width="45%">' . HTML::a('rockart.artemiris.org/archsite/' . $id,
                'http://rockart.artemiris.org/' . Yii::$app->language . '/archsite/' . $id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RSF #18-78-10079') . '</td>
                </tr>
            </table>'
        );
        $mpdf->WriteHTML($this->renderPartial('pdf_view',['archsite'=>$archsite]));

        foreach ($areas as $area){
            $petroglyphs = $area->petroglyphs;
            usort($petroglyphs, "\\frontend\\controllers\\ArchsiteController::usortModelsPredicate");
            $mpdf->AddPage();
            $mpdf->SetHTMLFooter('
            <hr>
            <table width="100%">
                <tr>
                    <td width="45%">' . Yii::t('app', 'Prehistoric Art in Eurasia Lab') . '</td>
                    <td width="10%" align="center">{PAGENO}</td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Novosibirsk State University') . '</td>
                </tr>
                <tr>
                    <td width="45%">' . HTML::a('rockart.artemiris.org/area/' . $area->id,
                    'http://rockart.artemiris.org/' . Yii::$app->language . '/area/' . $area->id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RSF #18-78-10079') . '</td>
                </tr>
            </table>'
            );
            $mpdf->WriteHTML($this->renderPartial('area_pdf_view',['area'=>$area, 'archsiteName'=>$archsite->name]));

            foreach ($petroglyphs as $petroglyph) {
                $pdf_object = PetroglyphPdfUtil::GetPetroglyphPdfObject($petroglyph);
                $mpdf->AddPage();
                $mpdf->SetHTMLFooter('
            <hr>
            <table width="100%">
                <tr>
                    <td width="45%">' . Yii::t('app', 'Prehistoric Art in Eurasia Lab') . '</td>
                    <td width="10%" align="center">{PAGENO}</td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Novosibirsk State University') . '</td>
                </tr>
                <tr>
                    <td width="45%">' . HTML::a('rockart.artemiris.org/petroglyph/' . $pdf_object['petroglyph']->id,
                        'http://rockart.artemiris.org/' . Yii::$app->language . '/petroglyph/' . $pdf_object['petroglyph']->id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RSF #18-78-10079') . '</td>
                </tr>
            </table>'
                );

                $mpdf->WriteHTML($this->renderPartial('petroglyph_pdf_view', [
                    'petroglyph' => $pdf_object['petroglyph'],
                    'image_objects' => $pdf_object['petroglyph_image_objects'],
                    'attrib_objects' => $pdf_object['petroglyph_attribute_objects'],
                    'parentName' => $archsite->name . '. ' . $area->name . '. '
                ]));
            }
        }

        foreach ($withoutArea as $p) {
            $pdf_object = PetroglyphPdfUtil::GetPetroglyphPdfObject($p);
            $mpdf->AddPage();
            $mpdf->SetHTMLFooter('
            <hr>
            <table width="100%">
                <tr>
                    <td width="45%">' . Yii::t('app', 'Prehistoric Art in Eurasia Lab') . '</td>
                    <td width="10%" align="center">{PAGENO}</td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Novosibirsk State University') . '</td>
                </tr>
                <tr>
                    <td width="45%">' . HTML::a('rockart.artemiris.org/petroglyph/' . $pdf_object['petroglyph']->id,
                    'http://rockart.artemiris.org/' . Yii::$app->language . '/petroglyph/' . $pdf_object['petroglyph']->id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RSF #18-78-10079') . '</td>
                </tr>
            </table>'
            );

            $mpdf->WriteHTML($this->renderPartial('petroglyph_pdf_view', [
                'petroglyph' => $pdf_object['petroglyph'],
                'image_objects' => $pdf_object['petroglyph_image_objects'],
                'attrib_objects' => $pdf_object['petroglyph_attribute_objects'],
                'parentName' => $archsite->name . '. '
            ]));
        }

        $mpdf->Output($archsite->name . '.pdf', 'D');
    }

    static function usortModelsPredicate($a, $b){
        $a_name = preg_replace(["/(?<!\d)(\d\d)(?!\d)/", "/(?<!\d)(\d)(?!\d)/"], ['0$1','00$1'], $a->name);
        $b_name = preg_replace(["/(?<!\d)(\d\d)(?!\d)/", "/(?<!\d)(\d)(?!\d)/"], ['0$1','00$1'], $b->name);
        return strcmp($a_name, $b_name);
    }
}