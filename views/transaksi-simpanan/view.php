<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiSimpanan */

$this->title = 'Detail Transaksi Simpanan '.$model->kode_trans;
$this->params['breadcrumbs'][] = ['label' => 'Simpanan Anggota', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transaksi-simpanan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ubah Simpanan', ['update', 'id' => $model->kode_trans], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Print Simpanan', ['print-kuitansi', 'id' => $model->kode_trans], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Hapus Simpanan', ['delete', 'id' => $model->kode_trans], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode_trans',
            'kode_simpanan',
            'no_anggota',
            'jumlah',
			'tanggal',
			'keterangan',
        ],
    ]) ?>

</div>
