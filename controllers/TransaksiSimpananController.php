<?php

namespace app\controllers;

use Yii;
use app\models\TransaksiSimpanan;
use app\models\TransaksiSimpananSearch;
use app\models\UploadForm;
use app\controllers\Authorization;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\Anggota;
use app\models\AnggotaSearch;
use app\models\Unit;
use kartik\mpdf\Pdf;


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

    public function actionIndex()
    {
        if(Authorization::authorize('transaksi-simpanan','index')){
            $searchModel = new TransaksiSimpananSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionView($id)
    {
        if(Authorization::authorize('transaksi-simpanan','view')){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }


    public function actionWajib($id)
    {
        if(Authorization::authorize('transaksi-simpanan','wajib')){
            $model = new TransaksiSimpanan();
            $anggota = new Anggota();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Simpanan berhasil dibuat!');
                return $this->redirect('index');
            } else {
                $model->tanggal = date('Y-m-d');
                $model->no_anggota = $id;
                return $this->render('wajib', [
                    'model' => $model,
                    'anggota' => $anggota,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionSukarela($id)
    {
        if(Authorization::authorize('transaksi-simpanan','sukarela')){
            $model = new TransaksiSimpanan();
            $anggota = new Anggota();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Simpanan berhasil dibuat!');
                return $this->redirect('index');
            } else {
                $model->tanggal = date('Y-m-d');
                $model->no_anggota = $id;
                return $this->render('sukarela',[
                    'model' => $model,
                    'anggota' => $anggota,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionAmbil($id)
    {
        if(Authorization::authorize('transaksi-simpanan','ambil')){
            $model = new TransaksiSimpanan();
            $anggota = new Anggota();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Simpanan berhasil dibuat!');
                return $this->redirect('index');
            } else {
                $model->tanggal = date('Y-m-d');
                $model->no_anggota = $id;
                return $this->render('ambil',[
                    'model' => $model,
                    'anggota' => $anggota,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionUpload()
    {
        if(Authorization::authorize('transaksi-simpanan','upload')){
            $model = new UploadForm();
            if(Yii::$app->request->isPost){
                $model->file = UploadedFile::getInstance($model, 'file');
                if($model->file && $model->validate()){
                    $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
                    $this::actionWriteToDatabase($model->file->baseName);
                }
            }
            return $this->render('upload', ['model' => $model]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionWriteToDatabase($filename)
    {
        $location = glob(Yii::getAlias('@realdir')."/web/uploads/".$filename.".csv")[0];
        $file = fopen($location, "r");

        $counter = 0; 
        if($filename == "transaksi_simpanan") {
            while(!feof($file)) {
                if($counter > 1) {
                    $data = fgetcsv($file);
                    $model = new TransaksiSimpanan();
                    $model->no_anggota = $data[0];
                    $model->kode_simpanan = $data[1];
                    $model->jumlah = $data[2];
                    $model->tanggal = date("Y-m-d");
                    $model->keterangan = "from CSV";
                    $model->save();
                }
                $counter = $counter + 1;
            }
            fclose($file);

            unlink($location);

            return $this->redirect(['index']);
        }
    }

    public function actionDaftar()
    {
        if(Authorization::authorize('transaksi-simpanan','daftar')) {
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

    public function actionList()
    {
        if(Authorization::authorize('transaksi-simpanan','list')){
            $searchModel = new AnggotaSearch();
            $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
            $queryParams["AnggotaSearch"]["status"] = "Aktif";
            $dataProvider = $searchModel->search($queryParams);

            return $this->render('list', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionSimpananAnggota($id)
    {
        if(Authorization::authorize('transaksi-simpanan','simpanan-anggota')){
            $searchModel = new TransaksiSimpananSearch();
            $trans = TransaksiSimpanan::find()->where(['no_anggota' => $id]);		
            $dataProvider = new ActiveDataProvider(['query'=>$trans]);

            return $this->render('simpanan-anggota', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionLihat($id)
    {
        if(Authorization::authorize('transaksi-simpanan','lihat')){
            return $this->render('lihat', [
                'model' => $this->findAnggota($id),
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionPrintKuitansi($id)
    {
        if(Authorization::authorize('transaksi-simpanan','print-kuitansi')){
            $sesuatu = TransaksiSimpanan::findOne($id);
            $anggota = Anggota::findOne($sesuatu->no_anggota);
            $unit = Unit::findOne($anggota->kode_unit);
            $pdf = new Pdf([
                'content' => $this->renderPartial('kuitansi',[
                    'kode_trans'=>$sesuatu->kode_trans,
                    'jenis'=>$sesuatu->kode_simpanan,
                    'jumlah'=>$sesuatu->jumlah,
					'tanggal'=>$sesuatu->tanggal,
                    'keterangan'=>$sesuatu->keterangan,
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

    public function actionSimpananAnggotaPrint($id)
    {
        if(Authorization::authorize('transaksi-simpanan','simpanan-anggota-print')){
            $searchModel = new TransaksiSimpananSearch();
            $test = TransaksiSimpanan::find()->where(['no_anggota' => $id]);		
            $dataProvider = new ActiveDataProvider(['query'=>$test]);
            $pdf = new Pdf([
                'content' => $this->renderPartial('simpanan-anggota-print',[
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
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

    protected function findModel($id)
    {
        if (($model = TransaksiSimpanan::findOne($id)) !== null) {
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
