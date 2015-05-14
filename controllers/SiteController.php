<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use kartik\mpdf\Pdf;

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

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return $this::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            return $this->render('index');
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
        if (Yii::$app->user->isGuest) {
            return $this::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return $this::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $pdf = new Pdf([
                'content' => $this->renderPartial('kuitansi'),
                'format' => Pdf::FORMAT_FOLIO,
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                'options' => [
                    'title' => 'Homepage',
                    'subject' => 'generate pdf using mpdf library'
                ],
            ]);

            return $pdf->render();
        }
    }	
    public function actionPrintAngsuran(){
        if (Yii::$app->user->isGuest) {
            return $this::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return $this::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
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
        }        
    }

    public function actionPrintTransaksi(){
        if (Yii::$app->user->isGuest) {
            return $this::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return $this::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
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
        }        
    }

    public function actionRedirectGuest(){
        return $this->redirect(['site/login']);
    }

    public function actionRedirectAnggota(){
        return $this->redirect(['site-anggota/index']);
    }
}
