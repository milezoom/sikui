<?php

namespace app\controllers;

use Yii;
use app\models\Anggota;
use app\models\UserRecord;
use app\models\AnggotaSearch;
use app\controllers\Authorization;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

class AnggotaController extends Controller
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
        if(Authorization::authorize('anggota','index')){
            $searchModel = new AnggotaSearch();
            $queryParams = array_merge(array(),Yii::$app->request->getQueryParams());
            $queryParams["AnggotaSearch"]["status"] = "Aktif";
            $dataProvider = $searchModel->search($queryParams);

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
        if(Authorization::authorize('anggota','view')){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionCreate()
    {
        if(Authorization::authorize('anggota','create')){
            $model = new Anggota();
            $user = new UserRecord();
            if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post()) && $model->validate()) {
                $model->save(false);
                $user->no_anggota = $model->no_anggota;
                $nama = explode(" ",$model->nama);
                $user->username = strtolower($nama[0]).$model->no_anggota;
                $password = Yii::$app->getSecurity()->generateRandomString(5);
                $user->password = $password;
                $user->save(false);
                Yii::$app->getSession()->setFlash('success', 'Anggota berhasil ditambah!');
                return $this->render('credential', [
                    'username'=>$user->username,
                    'password'=>$password
                ]);
            } else {
                $model->tgl_masuk = date('Y-m-d');
                return $this->render('create', [
                    'model' => $model,
                    'user' => $user
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionUpdate($id)
    {
        if(Authorization::authorize('anggota','update')){
            $model = $this->findModel($id);
            $user = UserRecord::find()->where(['no_anggota' => $id])->one();
            if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post()) && Model::validateMultiple([$model,$user])){
                $model->save(false);
                $user->save(false);
                Yii::$app->getSession()->setFlash('update', 'Data anggota berhasil di update!');
				return $this->redirect(['view', 'id' => $model->kode]);

            } else {
                return $this->render('update', [
                    'model' => $model,
                    'user' => $user
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    public function actionStatus($id)
    {
        if(Authorization::authorize('anggota','status')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('update', 'Status anggota berhasil di ubah!');
                return $this->redirect(['index']);
            } else {
                return $this->render('status', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Maaf, halaman tidak dapat diakses');
        }
    }

    protected function findModel($id)
    {
        if (($model = Anggota::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
