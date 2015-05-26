<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiPinjaman */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-pinjaman-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_anggota')->textInput(['readonly' => true])->label('Nomor Anggota *')?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <?= $form->field($model, 'tgl_pinjam')->textInput(['type' => 'date'])->label('Tanggal Peminjaman *') ?>
    
    <?= $form->field($model, 'jatuh_tempo')->textInput(['type' => 'date'])->label('Tanggal Jatuh Tempo *') ?>

    <?= $form->field($model, 'banyak_angsuran')->radioList(array('5' => '5 kali','10' => '10 kali', '15' => '15 kali'))->label('Banyak Angsuran')?> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?= Html::a('Batal', ['daftar'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
