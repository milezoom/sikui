<?php

namespace app\controllers;

use Yii;
//use app\models\Pinjaman;
//use app\models\PinjamanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PinjamanController extends Controller {
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
     * Show pinjaman transaction list
     * @return mixed
     */
    
    public function actionList()
    {
        /*
        $searchModel = new PinjamanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        });
        */
    }
    
    /**
     * Create new pinjaman transaction
     * If success, redirect to detail page to show newly created transaction pinjaman
     * @return mixed
     */
    public function actionCreate()
    {
        /*
        $model = new Pinjaman();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detail', 'id' => $model->kode_trans]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        */
    }
    
    /**
     * View detail data for a pinjaman transaction
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        /*
        return $this->render('detail',[
            'model' => $this->findModel($id);
        ]);
        */
    }
    
    /**
     * Create new pembayaran for a pinjaman transaction
     * If success, redirect to notifikasi page with sisa piutang for the detail in the page
     * @return mixed
     */
    public function actionBayar()
    {
        /*
        $model = new BayarPinjaman();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['notifikasi','id' => $model->kode_trans]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
        */
    }
    
    public function actionNotifikasi()
    {
        /*
        return $this->render('notifikasi',[
            'model => $this->findModelBayar($id)';
        ]);
        */
    }
    
    /**
     * Finds the Pinjaman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pinjaman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /*
        if (($model = Pinjaman::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        */
    }
    
    /**
     * Finds the BayarPinjaman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BayarPinjaman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBayar($id)
    {
        /*
        if (($model = BayarPinjaman::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        */
    }
}

?>