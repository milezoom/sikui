<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Anggota;
use app\models\AnggotaSearch;
use app\controllers\Authorization;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use app\models\TransaksiSimpananSearch;
use app\models\TransaksiSimpanan;
use app\models\TransaksiPinjaman;
use app\models\TransaksiPinjamanSearch;

class SiteAnggotaController extends Controller
{
    public $layout = "anggota";
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ];
    }

    public function actionView($id)
    {
        if(Authorization::authorize('site-anggota','view')){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionIndex()
    {
        if(Authorization::authorize('site-anggota','index')){
            $model = Anggota::findOne(Yii::$app->user->identity->no_anggota);
            return $this->render('profil', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionSimpananAnggota()
    {
        if(Authorization::authorize('site-anggota','simpanan-anggota')){
            $searchModel = new TransaksiSimpananSearch();
            $id = Anggota::findOne(Yii::$app->user->identity->no_anggota);
            $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
            $queryParams["TransaksiSimpananSearch"]["no_anggota"] = Yii::$app->user->identity->no_anggota;

            $dataProvider = $searchModel->search($queryParams);

            return $this->render('simpanan-anggota', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionPinjamanAnggota()
    {
        if(Authorization::authorize('site-anggota','pinjaman-anggota')){
            $searchModel = new TransaksiPinjamanSearch();
            $id = Anggota::findOne(Yii::$app->user->identity->no_anggota);
            $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
            $queryParams["TransaksiPinjamanSearch"]["no_anggota"] = Yii::$app->user->identity->no_anggota;

            $dataProvider = $searchModel->search($queryParams);

            return $this->render('pinjaman-anggota', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    protected function findModel($id)
    {
        if (($model = Anggota::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}