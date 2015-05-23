<?php

namespace app\controllers;

use Yii;
use app\models\TransaksiSimpanan;
use app\models\TransaksiSimpananSearch;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Anggota;
use app\models\AnggotaSearch;
use app\models\Unit;
use kartik\mpdf\Pdf;


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
     * Creates a new TransaksiSimpanan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionWajib($id)
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $model = new TransaksiSimpanan();
			$anggota = new Anggota();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('index');
            } else {
				$model->no_anggota = $id;
                return $this->render('Wajib', [
                    'model' => $model,
					'anggota' => $anggota,
                ]);
            }
        }
    }
    /**
     * Creates a new TransaksiSimpanan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionSukarela($id)
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $model = new TransaksiSimpanan();
			$anggota = new Anggota();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('index');
            } else {
				$model->no_anggota = $id;
                return $this->render('Sukarela',[
                    'model' => $model,
					'anggota' => $anggota,
                ]);
            }
        }        
    }
    /**
     * Creates a new TransaksiSimpanan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionAmbil($id)
    {
        if (Yii::$app->user->isGuest) {
            return SiteController::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return SiteController::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $model = new TransaksiSimpanan();
			$anggota = new Anggota();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('index');
            } else {
				$model->no_anggota = $id;
                return $this->render('Ambil',[
                    'model' => $model,
					'anggota' => $anggota,
                ]);
            }
        }        
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if(Yii::$app->request->isPost){
            $model->file = UploadedFile::getInstance($model, 'file');

            if($model->file && $model->validate()){
                $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
                $this::actionWriteToDatabase($model->file->baseName);
            }
        }

        return $this->render('upload', ['model' => $model]);
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
			$queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
			$queryParams["AnggotaSearch"]["status"] = "aktif";
            $dataProvider = $searchModel->search($queryParams);
			
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
	
	 public function actionPrintKuitansi($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this::actionRedirectGuest();
        } elseif (Yii::$app->user->identity->role == 'anggota') {
            return $this::actionRedirectAnggota();
        } elseif (Yii::$app->user->identity->role == 'admin') {
			//V temporary
			$sesuatu = TransaksiSimpanan::findOne($id);
			$anggota = Anggota::findOne($sesuatu->no_anggota);
			$unit = Unit::findOne($anggota->kode_unit);
            $pdf = new Pdf([
                'content' => $this->renderPartial('kuitansi',[
					'kode_trans'=>$sesuatu->kode_trans,
					'jenis'=>$sesuatu->kode_simpanan,
					'jumlah'=>$sesuatu->jumlah,
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
