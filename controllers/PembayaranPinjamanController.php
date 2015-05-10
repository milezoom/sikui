<?php

namespace app\controllers;

use Yii;
use app\models\PembayaranPinjaman;
use app\models\PembayaranPinjamanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PembayaranPinjamanController implements the CRUD actions for PembayaranPinjaman model.
 */
class PembayaranPinjamanController extends Controller
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
     * Lists all PembayaranPinjaman models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PembayaranPinjamanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PembayaranPinjaman model.
     * @param string $kode_trans
     * @param string $tgl_bayar
     * @return mixed
     */
    public function actionView($kode_trans, $tgl_bayar)
    {
        return $this->render('view', [
            'model' => $this->findModel($kode_trans, $tgl_bayar),
        ]);
    }

    /**
     * Creates a new PembayaranPinjaman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PembayaranPinjaman();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'kode_trans' => $model->kode_trans, 'tgl_bayar' => $model->tgl_bayar]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PembayaranPinjaman model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $kode_trans
     * @param string $tgl_bayar
     * @return mixed
     */
    public function actionUpdate($kode_trans, $tgl_bayar)
    {
        $model = $this->findModel($kode_trans, $tgl_bayar);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'kode_trans' => $model->kode_trans, 'tgl_bayar' => $model->tgl_bayar]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PembayaranPinjaman model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $kode_trans
     * @param string $tgl_bayar
     * @return mixed
     */
    public function actionDelete($kode_trans, $tgl_bayar)
    {
        $this->findModel($kode_trans, $tgl_bayar)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PembayaranPinjaman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $kode_trans
     * @param string $tgl_bayar
     * @return PembayaranPinjaman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($kode_trans, $tgl_bayar)
    {
        if (($model = PembayaranPinjaman::findOne(['kode_trans' => $kode_trans, 'tgl_bayar' => $tgl_bayar])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
