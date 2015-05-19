<?php

namespace app\controllers;

use Yii;
use app\models\TransaksiPinjaman;
use app\models\TransaksiPinjamanSearch;
use app\models\Anggota;
use app\models\AnggotaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransaksiPinjamanController implements the CRUD actions for TransaksiPinjaman model.
 */
class TransaksiPinjamanController extends Controller
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
     * Lists all TransaksiPinjaman models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $searchModel = new TransaksiPinjamanSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
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

    

    /**
     * Updates an existing TransaksiPinjaman model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->kode_trans]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }        
    }

    /**
     * Deletes an existing TransaksiPinjaman model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }        
    }

    /**
     * Finds the TransaksiPinjaman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TransaksiPinjaman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TransaksiPinjaman::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 /**
     * Creates a new TransaksiPinjaman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUang($id)
    {
        $model = new TransaksiPinjaman();
		$anggota = new Anggota();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->kode_trans]);
        } else {
			$model->no_anggota = $id;
            return $this->render('uang', [
                'model' => $model,
				'anggota' => $anggota,
            ]);
        }
    }
	/**
     * Add Simpanan Sukarela to an existing Anggota model.
     * If successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
    
    public function actionAmbil($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->no_anggota]);
        } else {
            return $this->render('ambil',[
                'model' => $model,
            ]);
        }
    }*/
	
	 /**
     * Creates a new TransaksiPinjaman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBarang($id)
    {
        $model = new TransaksiPinjaman();
		$anggota = new Anggota();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->kode_trans]);
        } else {            
            return $this->render('barang', [
               'model' => $model,
				'anggota' => $anggota,
            ]);
        }
    }
	
	/**
     * Lists all TransaksiPinjaman models.
     * @return mixed
     */
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
