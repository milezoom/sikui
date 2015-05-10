<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PembayaranPinjamanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pembayaran-pinjaman-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kode_trans') ?>

    <?= $form->field($model, 'tgl_bayar') ?>

    <?= $form->field($model, 'no_angsuran') ?>

    <?= $form->field($model, 'jumlah') ?>

    <?= $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
