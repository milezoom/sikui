<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiSimpananSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-simpanan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kode_trans') ?>

    <?= $form->field($model, 'kode_simpanan') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'no_anggota') ?>

    <?= $form->field($model, 'jumlah') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
