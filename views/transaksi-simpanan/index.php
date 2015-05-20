<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransaksiSimpananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Transaksi Simpanan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-simpanan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_trans',
            'kode_simpanan',
            'tanggal',
            'no_anggota',
            'jumlah',
            // 'keterangan',

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
