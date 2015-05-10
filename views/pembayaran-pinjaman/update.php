<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PembayaranPinjaman */

$this->title = 'Update Pembayaran Pinjaman: ' . ' ' . $model->kode_trans;
$this->params['breadcrumbs'][] = ['label' => 'Pembayaran Pinjamen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode_trans, 'url' => ['view', 'kode_trans' => $model->kode_trans, 'tgl_bayar' => $model->tgl_bayar]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pembayaran-pinjaman-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
