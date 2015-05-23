<?php

namespace app\controllers;

use Yii;
use app\models\TransaksiPinjaman;
use app\models\TransaksiPinjamanSearch;
use app\models\Anggota;
use app\models\AnggotaSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $searchModel = new TransaksiPinjamanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPenunggak()
    {
        $searchModel = new TransaksiPinjamanSearch();
        $query = TransaksiPinjaman::find()->where(['<','jatuh_tempo',date('Y-m-d')]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        return $this->render('penunggak', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);        
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }



    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->kode_trans]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']); 
    }

    protected function findModel($id)
    {
        if (($model = TransaksiPinjaman::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUang($id)
    {
        $model = new TransaksiPinjaman();
        $anggota = new Anggota();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
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
    }

    public function actionBarang($id)
    {
        $model = new TransaksiPinjaman();
        $anggota = new Anggota();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->kode_trans]);
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d',strtotime('+1 month'));
            $tanggal = strtotime($tanggal->format('Y').'-'.$tanggal->format('m').'-15');
            $model->jatuh_tempo = $tanggal;
            $model->kode_pinjaman = 'PJBG';
            $model->no_anggota = $id;
            return $this->render('barang', [
                'model' => $model,
                'anggota' => $anggota,
            ]);
        }
    }

    public function actionDaftar()
    {
        $searchModel = new AnggotaSearch();
        $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
        $queryParams["AnggotaSearch"]["status"] = "aktif";
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('daftar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);        
    }

    public function actionLihat($id)
    {
        return $this->render('lihat', [
            'model' => $this->findAnggota($id),
        ]);        
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
