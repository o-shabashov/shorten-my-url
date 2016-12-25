<?php

namespace app\controllers;

use app\models\Url;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'short' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @param string|null $url
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex(string $url = null)
    {
        if ($url && $model = Url::find()->where(['short' => $url])->one()) {
            return $this->redirect($model->source);
        }

        $model = new Url();

        return $this->render('index', ['model' => $model]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionShort()
    {
        $model = new Url();
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->renderAjax('_short', ['model' => $model]);
        }

        return $this->goHome();
    }
}
