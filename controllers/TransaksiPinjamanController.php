<?php

namespace app\controllers;

use Yii;
use app\models\TransaksiPinjaman;
use app\models\TransaksiPinjamanSearch;
use app\models\Anggota;
use app\models\AnggotaSearch;
use app\controllers\Authorization;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\BarangSearch;
use app\models\Barang;

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

    public function actionIndex()
    {
        if(Authorization::authorize('transaksi-pinjaman','index')){
            $searchModel = new TransaksiPinjamanSearch();
            $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
            $queryParams["TransaksiPinjamanSearch"]["kode_pinjaman"] = "PJBG";
            $dataProvider = $searchModel->search($queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionPenunggak()
    {
        if(Authorization::authorize('transaksi-pinjaman','penunggak')){
            $searchModel = new TransaksiPinjamanSearch();
            $query = TransaksiPinjaman::find()->where(['<','jatuh_tempo',date('Y-m-d')]);
            $dataProvider = new ActiveDataProvider(['query' => $query]);

            return $this->render('penunggak', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);  
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionView($id)
    {
        if(Authorization::authorize('transaksi-pinjaman','view')){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }



    public function actionUpdate($id)
    {
        if(Authorization::authorize('transaksi-pinjaman','update')){
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->kode_trans]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionDelete($id)
    {
        if(Authorization::authorize('transaksi-pinjaman','delete')) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']); 
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionUang($id)
    {
        if(Authorization::authorize('transaksi-pinjaman','uang')){
            $model = new TransaksiPinjaman();
            $anggota = new Anggota();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Pinjaman uang berhasil ditambah!');
                return $this->redirect(['index', 'id' => $model->kode_trans]);
            } else {
                date_default_timezone_set('Asia/Jakarta');
                $tanggal = date('Y-m-d',strtotime('+1 month'));
                $tanggal = strtotime($tanggal->format('Y').'-'.$tanggal->format('m').'-15');
                $model->jatuh_tempo = $tanggal;
                $model->kode_pinjaman = 'PJUG';
                $model->no_anggota = $id;
                return $this->render('uang', [
                    'model' => $model,
                    'anggota' => $anggota,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionBarang($id)
    {
        if(Authorization::authorize('transaksi-pinjaman','barang')){
            $model = new TransaksiPinjaman();
            $anggota = new Anggota();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Pinjaman barang berhasil ditambah!');
                return $this->redirect(['index', 'id' => $model->kode_trans]);
            } else {

                $model->kode_pinjaman = 'PJBG';
                $model->no_anggota = $id;
                return $this->render('barang', [
                    'model' => $model,
                    'anggota' => $anggota,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionDaftar()
    {
        if(Authorization::authorize('transaksi-pinjaman','daftar')){
            $searchModel = new AnggotaSearch();
            $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
            $queryParams["AnggotaSearch"]["status"] = "Aktif";
            $dataProvider = $searchModel->search($queryParams);
            return $this->render('daftar', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);        
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionLihat($id)
    {
        if(Authorization::authorize('transaksi-pinjaman','lihat')){
            return $this->render('lihat', [
                'model' => $this->findAnggota($id),
            ]);  
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    protected function findModel($id)
    {
        if (($model = TransaksiPinjaman::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findAnggota($id)
    {
        if (($model = Anggota::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
