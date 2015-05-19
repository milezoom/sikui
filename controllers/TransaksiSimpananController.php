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
            return $this->redirect(['index']);
        } 

        fclose($file);

        unlink($location);
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
}
