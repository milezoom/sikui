<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiSimpanan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-simpanan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_trans')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'kode_simpanan')-> dropdownList(['AMSP' => 'Ambil Simpanan']) ?>

    <?= $form->field($model, 'tanggal')->textInput() ?>

    <?= $form->field($model, 'no_anggota')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => 50]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
