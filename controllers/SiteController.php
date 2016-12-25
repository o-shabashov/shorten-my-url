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
     * @param string $url
     *
     * @return string
     */
    public function actionIndex(string $url = null)
    {
        $model = new Url();

        return $this->render('index', ['model' => $model]);
    }

    public function actionShort()
    {
        $model = new Url();
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->renderAjax('_short', ['model' => $model]);
        }
    }
}
