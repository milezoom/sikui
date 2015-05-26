<?php

namespace app\controllers;

use Yii;
use app\models\PembayaranPinjaman;
use app\models\PembayaranPinjamanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\Anggota;
use app\models\AnggotaSearch;
use app\models\TransaksiPinjaman;
use app\models\TransaksiPinjamanSearch;
use app\models\Unit;
use kartik\mpdf\Pdf;
use app\controllers\Authorization;
use yii\data\ActiveDataProvider;

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

    public function actionIndeks($id)
    {
        if(Authorization::authorize('pembayaran-pinjaman','index')){
            $searchModel = new PembayaranPinjamanSearch();
			$test = PembayaranPinjaman::find()->where(['kode_trans' => $id]);		
            $dataProvider = new ActiveDataProvider(['query'=>$test]);

            return $this->render('indeks', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);   
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
		
			$searchModel = new TransaksiPinjamanSearch();
            $test = TransaksiPinjaman::find()->where(['no_anggota' => $id]);		
            $dataProvider = new ActiveDataProvider(['query'=>$test]);

            return $this->render('pinjaman-anggota', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionView($kode_trans, $tgl_bayar)
    {
        if(Authorization::authorize('pembayaran-pinjaman','view')) {
            return $this->render('view', [
                'model' => $this->findModel($kode_trans, $tgl_bayar),
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionCreate()
    {
        if(Authorization::authorize('pembayaran-pinjaman','create')){
            $model = new PembayaranPinjaman();
            if ($model->load(Yii::$app->request->post()) && $model->no_angsuran <= 15 && $model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Pembayaran pinjaman berhasil ditambah!');
                return $this->redirect(['view', 'kode_trans' => $model->kode_trans, 'tgl_bayar' => $model->tgl_bayar]);
            } 
            else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionPrintKuitansi($id)
    {
        if(Authorization::authorize('pembayaran-pinjaman','print-kuitansi')){
            $bayar = PembayaranPinjaman::findOne($id);
            $transaksi = TransaksiPinjaman::findOne($bayar->kode_trans);
            $anggota = Anggota::findOne($transaksi->no_anggota);
            $unit = Unit::findOne($anggota->kode_unit);
            $pdf = new Pdf([
                'content' => $this->renderPartial('kuitansi',[
                    'kode_pinjam'=>$transaksi->kode_trans,
                    'jenis'=>$transaksi->kode_pinjaman,
                    'jumlah_pinjam'=>$transaksi->jumlah,
                    'banyak_angsuran'=>$transaksi->banyak_angsuran,
                    'tanggal'=>$bayar->tgl_bayar,
                    'no_angsuran'=>$bayar->no_angsuran,
                    'jumlah'=>$bayar->jumlah,
					'jasa'=>$bayar->jasa,
					'denda'=>$bayar->denda,
                    'no_anggota'=>$anggota->no_anggota,	
                    'nama_unit'=>$unit->nama,
                    'nama'=>$anggota->nama,
                    'wajib'=>$anggota->total_simpanan_wajib,
                    'sukarela'=>$anggota->total_simpanan_sukarela,
					 
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

	public function actionList()
    {
            $searchModel = new AnggotaSearch();
            $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
            $queryParams["AnggotaSearch"]["status"] = "Aktif";
            $dataProvider = $searchModel->search($queryParams);

            return $this->render('list', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }
	
	public function actionPinjamanAnggota($id)
    {
            $searchModel = new TransaksiPinjamanSearch();
            $test = TransaksiPinjaman::find()->where(['no_anggota' => $id]);		
            $dataProvider = new ActiveDataProvider(['query'=>$test]);

            return $this->render('pinjaman-anggota', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionUpdate($kode_trans, $tgl_bayar)
    {
        if(Authorization::authorize('pembayaran-pinjaman','update')){
            $model = $this->findModel($kode_trans, $tgl_bayar);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'kode_trans' => $model->kode_trans, 'tgl_bayar' => $model->tgl_bayar]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }      
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionDelete($kode_trans, $tgl_bayar)
    {
        if(Authorization::authorize('pembayaran-pinjaman','delete')){
            $this->findModel($kode_trans, $tgl_bayar)->delete();
            return $this->redirect(['index']);        
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    protected function findModel($kode_trans, $tgl_bayar)
    {
        if (($model = PembayaranPinjaman::findOne(['kode_trans' => $kode_trans, 'tgl_bayar' => $tgl_bayar])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
