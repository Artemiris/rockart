<?php

namespace backend\controllers;

use backend\models\UserForm;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * User controller
 */
class UserController extends BaseController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = User::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('index', ['provider' => $provider]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new UserForm();

        $app_roles = Yii::$app->authManager->getRoles();
        $app_perm = Yii::$app->authManager->getPermissions();

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['view', 'id' => $model->model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => ArrayHelper::map($app_roles, 'name', 'description'),
            'permissions' => ArrayHelper::map($app_perm, 'name', 'description'),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws HttpException
     */
    public function actionView($id)
    {
        $model = User::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $model = new UserForm();
        $model->setModel($this->findModel($id));

        $app_roles = Yii::$app->authManager->getRoles();
        $app_perm = Yii::$app->authManager->getPermissions();

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['view', 'id' => $id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => ArrayHelper::map($app_roles, 'name', 'description'),
            'permissions' => ArrayHelper::map($app_perm, 'name', 'description'),
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = User::findOne($id);

        if (empty($model) or $id == Yii::$app->user->id) {
            throw new HttpException(500);
        }

        $model->delete();

        return $this->redirect(['user/index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
