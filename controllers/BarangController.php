<?php

namespace app\controllers;

use Yii;
use app\models\Barang;
use app\models\BarangSearch;
use app\controllers\Authorization;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

/**
 * BarangController implements the CRUD actions for Barang model.
 */
class BarangController extends Controller
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
        if(Authorization::authorize('barang','index')){
            $searchModel = new BarangSearch();
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
        if(Authorization::authorize('barang','view')){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionCreate()
    {
        if(Authorization::authorize('barang','create')){
            $model = new Barang();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Barang berhasil ditambah!');
                return $this->redirect(['view', 'id' => $model->kode]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionUpdate($id)
    {
        if(Authorization::authorize('barang','update')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('update', 'Barang berhasil di update!');
                return $this->redirect(['view', 'id' => $model->kode]);
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
        if(Authorization::authorize('barang','delete')){
            $this->findModel($id)->delete();
            Yii::$app->getSession()->setFlash('delete', 'Barang berhasil di hapus!');
            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionProduk()
    {
        if(Authorization::authorize('barang','produk')){
            $searchModel = new BarangSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $this->layout = 'anggota';
            return $this->render('produk', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    //FIXME: masih error nih :'(
    public function actionUpload()
    {
        if(Authorization::authorize('barang','upload')){
            $model = new UploadForm();
            if (Yii::$app->request->isPost) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->file && $model->validate()) {                
                    $model->file->saveAs('uploads/barang' . $model->file->baseName . '.' . $model->file->extension);
                }
            }
            return $this->render('upload', ['model' => $model]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    protected function findModel($id)
    {
        if (($model = Barang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
