<?php

namespace app\controllers;

use Yii;
use app\models\Anggota;
use app\models\Unit;
use app\controllers\Authorization;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use kartik\mpdf\Pdf;
use yii\models\Settingan;

class SiteController extends Controller
{
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

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($action->id=='error')
                $this->layout ='guest';
            return true;
        } else {
            return false;
        }
    }

    public function actionIndex()
    {
        if(Authorization::authorize('site','index')){
            return $this->render('index');
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this::actionIndex();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            if (Yii::$app->user->identity->role == 'admin'){
                return $this::actionIndex();
            } elseif (Yii::$app->user->identity->role == 'anggota') {                
                return $this::actionRedirectAnggota();
            }
        } else {
            $this->layout = 'guest';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionPrintKuitansi()
    {
        if(Authorization::authorize('site','print-kuitansi')){
            $sesuatu = Anggota::findOne(2015050005);
            $unit = Unit::findOne($sesuatu->kode_unit);
            $pdf = new Pdf([
                'content' => $this->renderPartial('kuitansi',[
                    'nama_anggota'=>$sesuatu->nama,
                    'no_anggota'=>$sesuatu->no_anggota,
                    'unit'=>$unit->nama,
                ]),
                'format' => Pdf::FORMAT_FOLIO,
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                'options' => [
                    'title' => 'Homepage',
                    'subject' => 'generate pdf using mpdf library'
                ],
            ]);

            return $pdf->render();
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionPrintAngsuran() 
    {
        if(Authorization::authorize('site','print-angsuran')){
            $pdf = new Pdf([
                'content' => $this->renderPartial('print-angsuran'),
                'format' => Pdf::FORMAT_FOLIO,
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                'options' => [
                    'title' => 'Homepage',
                    'subject' => 'generate pdf using mpdf library'
                ],
            ]);

            return $pdf->render();
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }        

    public function actionPrintTransaksi()
    {
        if(Authorization::authorize('site','print-transaksi')){
            $pdf = new Pdf([
                'content' => $this->renderPartial('transaksi'),
                'format' => Pdf::FORMAT_A4,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'options' => [
                    'title' => 'Homepage',
                    'subject' => 'generate pdf using mpdf library'
                ],
            ]);

            return $pdf->render();
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionRedirectGuest(){
        return $this->redirect(['site/login']);
    }

    public function actionRedirectAnggota(){
        return $this->redirect(['site-anggota/index']);
    }

}
