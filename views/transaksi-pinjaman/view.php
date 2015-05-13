<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiPinjaman */

$this->title = $model->kode_trans;
$this->params['breadcrumbs'][] = ['label' => 'Pinjaman Anggota', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transaksi-pinjaman-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ubah Pinjaman', ['update', 'id' => $model->kode_trans], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Hapus Pinjaman', ['delete', 'id' => $model->kode_trans], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
		<?= Html::a('Pembayaran Pinjaman', ['/pembayaran-pinjaman/create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode_trans',
            'kode_pinjaman',
            'no_anggota',
            'jumlah',
            'sisa_piutang',
            'tgl_pinjam',
            'jatuh_tempo',
            'banyak_angsuran',
            'denda',
            'bunga',
            'kode_barang',
            'keterangan',
        ],
    ]) ?>

</div>
