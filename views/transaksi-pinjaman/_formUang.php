<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiPinjaman */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-pinjaman-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_pinjaman')->textInput(['maxlength' => 4]) ?>

    <?= $form->field($model, 'no_anggota')?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <?= $form->field($model, 'tgl_pinjam')->textInput(['type' => 'date']) ?>
    
    <?= $form->field($model, 'jatuh_tempo')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'banyak_angsuran')->radioList(array('5' => '5 kali','10' => '10 kali', '15' => '15 kali'))?> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
