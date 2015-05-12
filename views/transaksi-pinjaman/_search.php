<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiPinjamanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-pinjaman-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kode_trans') ?>

    <?= $form->field($model, 'kode_pinjaman') ?>

    <?= $form->field($model, 'no_anggota') ?>

    <?= $form->field($model, 'jumlah') ?>

    <?= $form->field($model, 'sisa_piutang') ?>

    <?php // echo $form->field($model, 'tgl_pinjam') ?>

    <?php // echo $form->field($model, 'jatuh_tempo') ?>

    <?php // echo $form->field($model, 'banyak_angsuran') ?>

    <?php // echo $form->field($model, 'denda') ?>

    <?php // echo $form->field($model, 'bunga') ?>

    <?php // echo $form->field($model, 'kode_barang') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
