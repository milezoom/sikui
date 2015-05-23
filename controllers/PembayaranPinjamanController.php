<?php

namespace app\controllers;

use Yii;
use app\models\PembayaranPinjaman;
use app\models\PembayaranPinjamanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Anggota;
use app\models\TransaksiPinjaman;
use app\models\Unit;
use kartik\mpdf\Pdf;

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

    public function actionIndex()
    {
		if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
        $searchModel = new PembayaranPinjamanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);   
			}
    }

    public function actionView($kode_trans, $tgl_bayar)
    {
		if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
        return $this->render('view', [
            'model' => $this->findModel($kode_trans, $tgl_bayar),
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
		}
    }
	
	public function actionPrintKuitansi($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return $this::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
			//V temporary
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
        }
    }	

    public function actionUpdate($kode_trans, $tgl_bayar)
    {
	if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
        $model = $this->findModel($kode_trans, $tgl_bayar);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'kode_trans' => $model->kode_trans, 'tgl_bayar' => $model->tgl_bayar]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }      
}		
    }

    public function actionDelete($kode_trans, $tgl_bayar)
    {
	if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
        $this->findModel($kode_trans, $tgl_bayar)->delete();
        return $this->redirect(['index']);        
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
