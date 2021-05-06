<?php
namespace frontend\controllers;

use common\models\Petroglyph;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
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
        $petroglyph = Petroglyph::find()->where(['id'=>$id])->one();
        $petroglyph_image_objects = [];
        if(!empty($petroglyph->image)){
            $petroglyph_image_objects[] = [
                'name' => Yii::t('model', 'Image'),
                'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImage,
                'author' => $petroglyph->img_author,
                'copyright' => $petroglyph->img_copyright,
                'source' => $petroglyph->img_source
            ];
        }
        if(!empty($petroglyph->im_dstretch)){
            $petroglyph_image_objects[] = [
                'name' => Yii::t('model', 'Image DStretch'),
                'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDstretch,
                'author' => $petroglyph->ds_img_author,
                'copyright' => $petroglyph->ds_img_copyright,
                'source' => $petroglyph->ds_img_source
            ];
        }
        if(!empty($petroglyph->im_drawing)){
            $petroglyph_image_objects[] = [
                'name' => Yii::t('model', 'Drawing image'),
                'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImDrawing,
                'author' => $petroglyph->dr_img_author,
                'copyright' => $petroglyph->dr_img_copyright,
                'source' => $petroglyph->dr_img_source
            ];
        }
        if(!empty($petroglyph->im_overlay)){
            $petroglyph_image_objects[] = [
                'name' => Yii::t('model', 'Image overlay'),
                'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImOverlay,
                'author' => $petroglyph->ov_img_author,
                'copyright' => $petroglyph->ov_img_copyright,
                'source' => $petroglyph->ov_img_source
            ];
        }
        if(!empty($petroglyph->im_reconstruction)){
            $petroglyph_image_objects[] = [
                'name' => Yii::t('model', 'Reconstruction image'),
                'image' => Petroglyph::SRC_IMAGE . '/' . $petroglyph->thumbnailImReconstr,
                'author' => $petroglyph->re_img_author,
                'copyright' => $petroglyph->re_img_copyright,
                'source' => $petroglyph->re_img_source
            ];
        }

        $petroglyph_attrib_objects = [];
        if(!empty($petroglyph->cultures)){
            $petroglyph_attrib_objects[] = [
                'name' => Yii::t('app', 'Culture'),
                'data' => implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->cultures))
            ];
        }
        if(!empty($petroglyph->epochs)){
            $petroglyph_attrib_objects[] = [
                'name' => Yii::t('app', 'Epoch'),
                'data' => implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->epochs))
            ];
        }
        if(!empty($petroglyph->styles)){
            $petroglyph_attrib_objects[] = [
                'name' => Yii::t('app', 'Style'),
                'data' => implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->styles))
            ];
        }
        if(!empty($petroglyph->methods)){
            $petroglyph_attrib_objects[] = [
                'name' => Yii::t('app', 'Method'),
                'data' => implode (", ",
                    array_map(function($obj) { return $obj->name; }, $petroglyph->methods))
            ];
        }

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
                    <td width="45%">' . HTML::a('rockart.artemiris.org/petroglyph/' . $petroglyph->id,
                                                'http://rockart.artemiris.org/' . Yii::$app->language . '/petroglyph/' . $petroglyph->id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RNF #18-78-10079') . '</td>
                </tr>
            </table>'
        );
        $mpdf->WriteHTML($this->renderPartial('pdf_view', [
            'petroglyph'=>$petroglyph,
            'image_objects' => $petroglyph_image_objects,
            'attrib_objects' => $petroglyph_attrib_objects
        ]));
        $mpdf->Output($petroglyph->name . '.pdf', 'D');
    }
}