<?php

namespace frontend\controllers;

use common\models\Culture;
use common\models\Epoch;
use common\models\Method;
use common\models\Style;
use common\models\Petroglyph;
use common\models\PetroglyphImage;
use common\models\PetroglyphThreeD;
use common\models\Archsite;
use common\models\Composition;

use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;

/**
 * Manager controller
 */
class ManagerController extends Controller
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
                        'roles' => ['manager'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'culture-delete' => ['post'],
                    'epoch-delete' => ['post'],
                    'method-delete' => ['post'],
                    'petroglyph-delete' => ['post'],
                    'petroglyph-image-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionCulture()
    {
        $query = Culture::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('culture_list', ['provider' => $provider]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCultureCreate()
    {
        $model = new Culture();

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/culture-view', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('culture_create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws HttpException
     */
    public function actionCultureView($id)
    {
        $model = Culture::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        return $this->render('culture_view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionCultureUpdate($id)
    {
        $model = Culture::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->refresh();
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('culture_update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCultureDelete($id)
    {
        $model = Culture::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        if (empty($model->petroglyphs)) {
            $model->delete();
        } else {
            \Yii::$app->session->setFlash('error', 'Невозможно удалить, так как к нему использвется в петроглифах');
        }

        return $this->redirect(['manager/culture']);
    }

    /**
     * @return string
     */
    public function actionEpoch()
    {
        $query = Epoch::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('epoch_list', ['provider' => $provider]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionEpochCreate()
    {
        $model = new Epoch();

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/epoch-view', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('epoch_create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws HttpException
     */
    public function actionEpochView($id)
    {
        $model = Epoch::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        return $this->render('epoch_view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionEpochUpdate($id)
    {
        $model = Epoch::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->refresh();
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('epoch_update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionEpochDelete($id)
    {
        $model = Epoch::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        if (empty($model->petroglyphs)) {
            $model->delete();
        } else {
            \Yii::$app->session->setFlash('error', 'Невозможно удалить, так как к нему использвется в петроглифах');
        }

        return $this->redirect(['manager/epoch']);
    }

    /**
     * @return string
     */
    public function actionMethod()
    {
        $query = Method::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('method_list', ['provider' => $provider]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionMethodCreate()
    {
        $model = new Method();

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/method-view', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('method_create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws HttpException
     */
    public function actionMethodView($id)
    {
        $model = Method::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        return $this->render('method_view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionMethodUpdate($id)
    {
        $model = Method::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->refresh();
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('method_update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionMethodDelete($id)
    {
        $model = Method::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        if (empty($model->petroglyphs)) {
            $model->delete();
        } else {
            \Yii::$app->session->setFlash('error', 'Невозможно удалить, так как к нему использвется в петроглифах');
        }

        return $this->redirect(['manager/method']);
    }

    /**
     * @return string
     */
    public function actionStyle()
    {
        $query = Style::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('style_list', ['provider' => $provider]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionStyleCreate()
    {
        $model = new Style();

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/style-view', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('style_create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws HttpException
     */
    public function actionStyleView($id)
    {
        $model = Style::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        return $this->render('style_view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionStyleUpdate($id)
    {
        $model = Style::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->refresh();
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('style_update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionStyleDelete($id)
    {
        $model = Style::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        if (empty($model->petroglyphs)) {
            $model->delete();
        } else {
            \Yii::$app->session->setFlash('error', 'Невозможно удалить, так как к нему использвется в петроглифах');
        }

        return $this->redirect(['manager/style']);
    }

    /**
     * @return string
     */
    public function actionPetroglyph()
    {
        $query = Petroglyph::find()->orderBy(['created_at' => SORT_DESC]);

        if (!\Yii::$app->request->get('showDeleted')) {
            $query->where(['deleted' => null]);
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('petroglyph_list', ['provider' => $provider]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionPetroglyphCreate()
    {
        $model = new Petroglyph();

        $archsites = ArrayHelper::map(Archsite::find()->all(), 'id', 'name');

        $cultures = ArrayHelper::map(Culture::find()->all(), 'id', 'name');
        $epochs = ArrayHelper::map(Epoch::find()->all(), 'id', 'name');
        $methods = ArrayHelper::map(Method::find()->all(), 'id', 'name');
        $styles = ArrayHelper::map(Style::find()->all(), 'id', 'name');

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/petroglyph-view', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('petroglyph_create', [
            'model' => $model,
            'archsites' => $archsites,
            'cultures' => $cultures,
            'epochs' => $epochs,
            'methods' => $methods,
            'styles' => $styles,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws HttpException
     */
    public function actionPetroglyphView($id)
    {
        $model = Petroglyph::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        $query = Composition::find()->where(['petroglyph_id' => $model->id]);

        $providerComposition = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        $query = PetroglyphImage::find()->where(['petroglyph_id' => $model->id]);

        $providerImage = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        $query = PetroglyphThreeD::find()->where(['petroglyph_id' => $model->id]);

        $providerThreeD = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('petroglyph_view', [
            'model' => $model,
            'providerComposition' => $providerComposition,
            'providerImage' => $providerImage,
            'providerThreeD' => $providerThreeD,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionPetroglyphUpdate($id)
    {
        $model = Petroglyph::find()->multilingual()->where(['id' => $id])->one();

        $archsites = ArrayHelper::map(Archsite::find()->all(), 'id', 'name');

        $cultures = ArrayHelper::map(Culture::find()->all(), 'id', 'name');
        $epochs = ArrayHelper::map(Epoch::find()->all(), 'id', 'name');
        $methods = ArrayHelper::map(Method::find()->all(), 'id', 'name');
        $styles = ArrayHelper::map(Style::find()->all(), 'id', 'name');

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
                $model->fileDstr = UploadedFile::getInstance($model, 'fileDstr');
                $model->fileDraw = UploadedFile::getInstance($model, 'fileDraw');
                $model->fileReconstr = UploadedFile::getInstance($model, 'fileReconstr');
                $model->fileOverlay = UploadedFile::getInstance($model, 'fileOverlay');
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/petroglyph-view', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('petroglyph_update', [
            'model' => $model,
            'archsites' => $archsites,
            'cultures' => $cultures,
            'epochs' => $epochs,
            'methods' => $methods,
            'styles' => $styles,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionPetroglyphDelete($id)
    {
        $model = Petroglyph::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        if (!empty($model->images)) {
            foreach ($model->images as $image) {
                $image->delete();
            }
        }

        $model->beforeDelete();
        $model->deleted = 1;
        $model->save();

        return $this->redirect(['manager/petroglyph']);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionPetroglyphImageCreate($id)
    {
        $model = new PetroglyphImage();

        $petroglyph = Petroglyph::findOne($id);

        if (empty($petroglyph)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->save()) {
                $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/petroglyph-view', 'id' => $petroglyph->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('petroglyph_image_create', [
            'model' => $model,
            'petroglyph' => $petroglyph,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws HttpException
     */
    public function actionPetroglyphImageView($id)
    {
        $model = PetroglyphImage::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        return $this->render('petroglyph_image_view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionPetroglyphImageUpdate($id)
    {
        $model = PetroglyphImage::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/petroglyph-image-view', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('petroglyph_image_update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionPetroglyphImageDelete($id)
    {
        $model = PetroglyphImage::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        $petroglyph = $model->petroglyph;
        $model->delete();

        return $this->redirect(['manager/petroglyph-view', 'id' => $petroglyph->id]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionPetroglyphThreeDCreate($id)
    {
        $model = new PetroglyphThreeD();

        $petroglyph = Petroglyph::findOne($id);

        if (empty($petroglyph)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/petroglyph-view', 'id' => $petroglyph->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('petroglyph_three_d_create', [
            'model' => $model,
            'petroglyph' => $petroglyph,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws HttpException
     */
    public function actionPetroglyphThreeDView($id)
    {
        $model = PetroglyphThreeD::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        return $this->render('petroglyph_three_d_view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionPetroglyphThreeDUpdate($id)
    {
        $model = PetroglyphThreeD::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/petroglyph-three-d-view', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('petroglyph_three_d_update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionPetroglyphThreeDDelete($id)
    {
        $model = PetroglyphThreeD::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        $petroglyph = $model->petroglyph;
        $model->delete();

        return $this->redirect(['manager/petroglyph-view', 'id' => $petroglyph->id]);
    }

    /**
     * @return string
     */
    public function actionArchsite()
    {
        $archsites = Archsite::find()->orderBy(['id' => SORT_DESC])->all();

        return $this->render('archsite_list', ['archsites' => $archsites]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionArchsiteCreate()
    {
        $model = new Archsite();

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/archsite-update', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('archsite_create', [
            'model' => $model
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionArchsiteUpdate($id)
    {
        $model = Archsite::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');

            if ($model->save()) {
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->refresh();
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('archsite_update', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionArchsiteDelete($id)
    {
        $model = Archsite::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        $model->delete();

        return $this->redirect(['manager/archsite']);
    }

    /**
     * @return string
     */
    public function actionComposition()
    {
        $compositions = Composition::find()->orderBy(['id' => SORT_DESC])->all();

        return $this->render('composition_list', ['compositions' => $compositions]);
    }

    /**
     * @param $id
     * @return string
     * @throws HttpException
     */
    public function actionCompositionView($id)
    {
        $model = Composition::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        return $this->render('composition_view', [
            'model' => $model,
        ]);
    }
    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionCompositionCreate($id)
    {
        $model = new Composition();
        $petroglyph = Petroglyph::findOne($id);

        if (empty($petroglyph)) {
            throw new HttpException(500);
        }
        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/composition-update', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('composition_create', [
            'model' => $model,
            'petroglyph' => $petroglyph,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionCompositionUpdate($id)
    {
        $model = Composition::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');

            if ($model->save()) {
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->refresh();
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('composition_update', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCompositionDelete($id)
    {
        $model = Composition::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        $model->delete();

        return $this->redirect(['manager/composition']);
    }

}
