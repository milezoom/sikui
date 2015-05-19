<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransaksiPinjamanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Riwayat Transaksi Pinjaman';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-pinjaman-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Transaksi Pinjaman', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_trans',
            'kode_pinjaman',
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

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
