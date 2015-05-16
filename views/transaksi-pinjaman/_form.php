<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiPinjaman */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-pinjaman-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_trans')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'kode_pinjaman')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'no_anggota')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <?= $form->field($model, 'sisa_piutang')->textInput() ?>

    <?= $form->field($model, 'tgl_pinjam')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'jatuh_tempo')->textInput() ?>

    <?= $form->field($model, 'banyak_angsuran')->textInput() ?>

    <?= $form->field($model, 'denda')->textInput() ?>

    <?= $form->field($model, 'kode_barang')->textInput(['maxlength' => 10]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
