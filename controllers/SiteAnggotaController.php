<?php

namespace app\controllers;

use Yii;
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
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
            $rangeTahun = [];
            $counter = 2015;
            while($counter<=intval(date('Y'))){
                array_push($rangeTahun,$counter);
                $counter=$counter+1;
            }
            $rangeBulan = ['Januari' => 1,
                           'Februari' => 2,
                           'Maret' => 3,
                           'April' => 4,
                           'Mei' => 5,
                           'Juni' => 6,
                           'Juli' => 7,
                           'Agustus' => 8,
                           'September' => 9,
                           'Oktober' => 10,
                           'November' => 11,
                           'Desember' => 12
                          ];
            $model = DynamicModel::validateData(compact('bulan','tahun'),[
                [['bulan','tahun'],'integer'],
            ]);
            
            if($model->load(Yii::$app->request->post())){
                
            }
            
            
            $searchModel = new TransaksiSimpananSearch();
            $id = Yii::$app->user->identity->no_anggota;
            $query = TransaksiSimpanan::find()->where(['no_anggota' => $id]);
            $dataProvider = new ActiveDataProvider(['query' => $query]);
            return $this->render('simpanan-anggota', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'rangeTahun' => $rangeTahun,
                'rangeBulan' => $rangeBulan
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionPinjamanAnggota()
    {
        if(Authorization::authorize('site-anggota','pinjaman-anggota')){
            $searchModel = new TransaksiPinjamanSearch();
            $id = Yii::$app->user->identity->no_anggota;
            $query = TransaksiPinjaman::find()->where(['no_anggota' => $id]);
            $dataProvider = new ActiveDataProvider(['query' => $query]);
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