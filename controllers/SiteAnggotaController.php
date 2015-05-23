<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Anggota;
use app\models\AnggotaSearch;
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
	if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } else{
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);}
    }
	
    public function actionIndex()
    {
	if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } else{
        $model = Anggota::findOne(Yii::$app->user->identity->no_anggota);
        return $this->render('profil', [
            'model' => $model,
        ]);}
    }
	
	public function actionSimpananAnggota(){
		$searchModel = new TransaksiSimpananSearch();
		$id = Anggota::findOne(Yii::$app->user->identity->no_anggota);
		//$test = TransaksiSimpanan::find()->where(['no_anggota' => $id])->all();
		$queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
		$queryParams["TransaksiSimpananSearch"]["no_anggota"] = Yii::$app->user->identity->no_anggota;
		
        $dataProvider = $searchModel->search($queryParams);

            return $this->render('simpanan-anggota', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
	
	}
	
	public function actionPinjamanAnggota(){
		$searchModel = new TransaksiPinjamanSearch();
		$id = Anggota::findOne(Yii::$app->user->identity->no_anggota);
		//$test = TransaksiSimpanan::find()->where(['no_anggota' => $id])->all();
		$queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
		$queryParams["TransaksiPinjamanSearch"]["no_anggota"] = Yii::$app->user->identity->no_anggota;
		
        $dataProvider = $searchModel->search($queryParams);

            return $this->render('pinjaman-anggota', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
	
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