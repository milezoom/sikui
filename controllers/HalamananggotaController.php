<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use kartik\mpdf\Pdf;

class halamanAnggotaController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
/**
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
    }*/

    public function actionIndex()
    {
        return $this->render('index');
    }
/**
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this::actionIndex();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			$peran = Yii::$app->user->identity->role;
			if($peran == 'admin'){
				return $this::actionIndex();
			}
			else if($peran == 'anggota'){
				$this->layout = 'indexAnggota';
            return $this::actionIndex();
			/**render('view', [
                'model' => $model,
            ]);
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
    
    public function actionPrint(){
        $pdf = new Pdf([
            'content' => $this->renderPartial('index'),
            'options' => [
                'title' => 'Homepage',
                'subject' => 'generate pdf using mpdf library'
            ],
        ]);
        
        return $pdf->render();
    }*/
}
