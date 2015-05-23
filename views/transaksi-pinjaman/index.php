<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransaksiPinjamanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Transaksi Pinjaman Barang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-pinjaman-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_trans',
            //'kode_pinjaman',
            'no_anggota',
            'jumlah',
            'sisa_piutang',
            // 'tgl_pinjam',
            // 'jatuh_tempo',
            // 'banyak_angsuran',
            // 'denda',
            // 'bunga',
            // 'kode_barang',
            // 'keterangan',

            ['class' => 'yii\grid\ActionColumn',
                          'template'=>'{view}',
                            'buttons'=>[
                              'view' => function ($url, $model) {     
                                return Html::a('<span >Lihat</span>', $url, [
                                        'title' => Yii::t('yii', 'Lihat Pinjaman'),
										'class' => 'btn btn-success',
                                ]);                                
                              }
							]                            
            ],
        ],
    ]); ?>

</div>
