<?php
namespace frontend\controllers;

use common\models\Petroglyph;
use common\utility\PetroglyphPdfUtil;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\HttpException;

/**
 * Class PetroglyphController
 * @package frontend\controllers
 */
class PetroglyphController extends BaseController
{

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
        $query->orderBy(['id' => SORT_DESC])->all();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $this->render('index', [
            'provider' => $provider,
            'filter' => $filter,
        ]);
    }

    public function actionView($id)
    {
        $query = Petroglyph::find()->where(['id' => $id])->andWhere(['deleted' => null]);

        if (!Yii::$app->user->can('manager')) {
            $query->andWhere(['public' => 1]);
        }

        $petroglyph = $query->one();

        if (empty($petroglyph)) {
            throw new HttpException(404);
        }

        $json_petroglyphs = null;
        $inherit_coords = '';
        if (!$petroglyph->lat || !$petroglyph->lng){
            $area = $petroglyph->area;
            $archsite = $petroglyph->archsite;
            if($area && $area->lat && $area->lng){
                $petroglyph->lat = $area->lat;
                $petroglyph->lng = $area->lng;
                $inherit_coords = 'area';
            } else if ($archsite->lat && $archsite->lng){
                $petroglyph->lat = $archsite->lat;
                $petroglyph->lng = $archsite->lng;
                $inherit_coords = 'archsite';
            }
        }
        if ($petroglyph->lat && $petroglyph->lng) {
            $array_petroglyphs[] = [
                'id' => $petroglyph->id,
                'name' => $petroglyph->name,
                'lat' => $petroglyph->lat,
                'lng' => $petroglyph->lng,
                'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImage,
            ];
            $json_petroglyphs = json_encode($array_petroglyphs, JSON_UNESCAPED_UNICODE);
        }

        $mapProvider = Yii::$app->request->get('mapProvider') == 'yandex' ? 'yandex' : 'google';

        return $this->render('view', [
            'json_petroglyphs' => $json_petroglyphs,
            'petroglyph' => $petroglyph,
            'mapProvider' => $mapProvider,
            'inherit_coords' => $inherit_coords,
        ]);
    }

    public function actionPdfView($id){
        $p = Petroglyph::find()->where(['id'=>$id])->one();
        $petroglyph_pdf = PetroglyphPdfUtil::GetPetroglyphPdfObject($p);

        $mpdf = new \Mpdf\Mpdf();
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
                    <td width="45%">' . HTML::a('rockart.artemiris.org/petroglyph/' . $id,
                                                'http://rockart.artemiris.org/' . Yii::$app->language . '/petroglyph/' . $id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RNF #18-78-10079') . '</td>
                </tr>
            </table>'
        );
        $mpdf->WriteHTML($this->renderPartial('pdf_view', [
            'petroglyph'=>$petroglyph_pdf['petroglyph'],
            'image_objects' => $petroglyph_pdf['petroglyph_image_objects'],
            'attrib_objects' => $petroglyph_pdf['petroglyph_attribute_objects']
        ]));
        $mpdf->Output($petroglyph_pdf['petroglyph']->name . '.pdf', 'D');
    }
}