<?php

namespace app\controllers;

use Yii;
use app\models\TransaksiSimpanan;
use app\models\TransaksiSimpananSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Anggota;
use app\models\AnggotaSearch;

/**
 * TransaksiSimpananController implements the CRUD actions for TransaksiSimpanan model.
 */
class TransaksiSimpananController extends Controller
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

    /**
     * Lists all TransaksiSimpanan models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $searchModel = new TransaksiSimpananSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }        
    }



    /**
     * Creates a new TransaksiSimpanan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionWajib()
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $model = new TransaksiSimpanan();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('index');
            } else {
                return $this->render('Wajib', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Creates a new TransaksiSimpanan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionSukarela()
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $model = new TransaksiSimpanan();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('index');
            } else {
                return $this->render('Sukarela',[
                    'model' => $model,
                ]);
            }
        }        
    }
    /**
     * Creates a new TransaksiSimpanan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionAmbil()
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $model = new TransaksiSimpanan();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('index');
            } else {
                return $this->render('Ambil',[
                    'model' => $model,
                ]);
            }
        }        
    }
    /**
     * Finds the TransaksiSimpanan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TransaksiSimpanan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TransaksiSimpanan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionDaftar()
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $searchModel = new AnggotaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('daftar', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }        
    }
	
	 /**
     * Displays a single TransaksiPinjaman model.
     * @param string $id
     * @return mixed
     */
    public function actionLihat($id)
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            return $this->render('lihat', [
                'model' => $this->findAnggota($id),
            ]);
        }        
    }
	
	 /**
     * Finds the TransaksiPinjaman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TransaksiPinjaman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findAnggota($id)
    {
        if (($model = Anggota::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
