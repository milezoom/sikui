<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\TransaksiSimpanan;
use app\models\TransaksiSimpananSearch;
use app\models\Anggota;
use app\models\AnggotaSearch;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiSimpanan */
$model = Yii::$app->user->identity->no_anggota;
$this->title = $model->no_anggota;
$coba = $model->no_anggota;
$this->params['breadcrumbs'][] = ['label' => 'TransaksiSimpanan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/**$query = new Query;
	$query->select('transaksi_simpanan.kode_trans, jenis_simpanan.nama, transaksi_simpanan.tanggal, transaksi_simpanan.jumlah, transaksi_simpanan.keterangan')
    ->from('transaksi_simpanan, jenis_simpanan')
    ->where (['transaksi_simpanan.no_anggota' => [$coba]], ['transaksi_simpanan.kode_simpanan' == 'jenis_simpanan.kode']);
	$rows = $query->all();
	$command = $query->createCommand();
	$rows = $command->queryAll();*/
?>
<div class="transaksi-simpanan-view">

    <h1><?= Html::encode($this->title) ?></h1>

     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_trans',
            'kode_simpanan',
            'no_anggota',
			'tanggal',
            'jumlah',
            'keterangan',
        ],
    ]); ?>

</div>
