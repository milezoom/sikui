<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PembayaranPinjaman */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pembayaran-pinjaman-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_trans')->textInput(['maxlength' => 10])->label('Kode Transaksi *') ?>

    <?= $form->field($model, 'tgl_bayar')->textInput(['type' => 'date'])->label('Tanggal Bayar *') ?>

    <?= $form->field($model, 'no_angsuran')->textInput()->label('Nomor Angsuran *') ?>

    <?= $form->field($model, 'jumlah')->textInput()->label('Jumlah Pembayaran *') ?>

	<?= $form->field($model, 'jasa')->textInput() ?>
	
	<?= $form->field($model, 'denda')->textInput() ?>
	
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
