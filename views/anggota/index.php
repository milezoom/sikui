<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnggotaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Anggota';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggota-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Anggota', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'no_anggota',
        'nama',
        //'kode_unit',
        'alamat',
        //'tgl_lahir',
        'total_simpanan',
        'total_pinjaman',

        ['class' => 'yii\grid\ActionColumn',
         'template'=>'{view}',
         'buttons'=>[
             'view' => function ($url, $model) {     
                 return Html::a('<span >Lihat</span>', $url, [
                     'title' => Yii::t('yii', 'Lihat Transaksi'),
                     'class' => 'btn btn-success',
                 ]);                                
             }                                
         ]                            
        ],

        ['class' => 'yii\grid\ActionColumn',
         'template'=>'{update}',
         'buttons'=>[
             'update' => function ($url, $model) {     
                 return Html::a('<span >Ubah</span>', $url, [
                     'title' => Yii::t('yii', 'Ubah Transaksi'),
                     'class' => 'btn btn-success',
                 ]);                                
             }
         ]                            
        ],

        ['class' => 'yii\grid\ActionColumn',
         'template'=>'{delete}',
         'buttons'=>[
             'delete' => function ($url, $model) {     
                 return Html::a('<span >Hapus</span>', $url, [
                     'title' => Yii::t('yii', 'Hapus Transaksi'),
                     'class' => 'btn btn-danger',
                 ]);                                
             }
         ]                            
        ],
    ],
]); ?>

</div>
