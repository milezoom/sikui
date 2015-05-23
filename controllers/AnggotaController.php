<?php

namespace app\controllers;

use Yii;
use app\models\Anggota;
use app\models\UserRecord;
use app\models\AnggotaSearch;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AnggotaController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
	if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
        $searchModel = new AnggotaSearch();
        $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
        $queryParams["AnggotaSearch"]["status"] = "Aktif";
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);}
    }

    public function actionView($id)
    {
	if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
}
    }

    public function actionCreate()
    {
	if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
        $model = new Anggota();
        $user = new UserRecord();

        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $model->save(false);
            $user->no_anggota = $model->no_anggota;
            $nama = explode(" ",$model->nama);
            $user->username = strtolower($nama[0]).$model->no_anggota;
            $password = Yii::$app->getSecurity()->generateRandomString(5);
            $user->password = $password;
            $user->save(false);
            return $this->render('credential', [
                'username'=>$user->username,
                'password'=>$password
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'user' => $user
            ]);
        }
        }
    }

    public function actionUpdate($id)
    {if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $model = $this->findModel($id);
            $user = UserRecord::find()->where(['no_anggota' => $id])->one();

            if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())
                && $model->save() && $user->save()){
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'user' => $user
                ]);
            }
        }        
		
    }

    public function actionStatus($id)
    {
	if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('status', [
                    'model' => $model,
                ]);
            }
        }  }     
		
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
