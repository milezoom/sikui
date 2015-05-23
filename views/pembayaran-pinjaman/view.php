<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PembayaranPinjaman */

$this->title = 'Detail Pembayaran Pinjaman: ' . ' ' .$model->kode_trans;
$this->params['breadcrumbs'][] = ['label' => 'Pembayaran Pinjamen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembayaran-pinjaman-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'kode_trans' => $model->kode_trans, 'tgl_bayar' => $model->tgl_bayar], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'kode_trans' => $model->kode_trans, 'tgl_bayar' => $model->tgl_bayar], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
		<?= Html::a('Daftar Pembayaran Pinjaman', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode_trans',
            'tgl_bayar',
            'no_angsuran',
            'jumlah',
        ],
    ]) ?>

</div>
