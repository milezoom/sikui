<?php

namespace app\controllers;

use Yii;
use app\models\Anggota;
use app\models\AnggotaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnggotaController implements the CRUD actions for Anggota model.
 */
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

    /**
     * Lists all Anggota models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $searchModel = new AnggotaSearch();
			$queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
			$queryParams["AnggotaSearch"]["status"] = "aktif";
            $dataProvider = $searchModel->search($queryParams);
			
			return $this->render('index', [
               'searchModel' => $searchModel,
               'dataProvider' => $dataProvider,
			]);
        }        
    }

    /**
     * Displays a single Anggota model.
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
     * Creates a new Anggota model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $model = new Anggota();
			$timezone = date_default_timezone_get();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->no_anggota]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }        
    }

    /**
     * Updates an existing Anggota model.
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
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }        
    }

    /**
     * Deletes an existing Anggota model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionStatus($id)
    {
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
        }        
    }

    /**
     * Finds the Anggota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Anggota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anggota::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
