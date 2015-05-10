<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Anggota */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anggota-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_anggota')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'kode_unit')->dropDownList(['0000000001'=> 'Fasilkom', '0000000002' => 'Rektorat']) ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'tgl_lahir')->textInput() ?>

    <?= $form->field($model, 'no_telepon')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'jenis_kelamin')->radioList(array('0' => 'Perempuan','1' => 'Laki-laki'))?>

    <?= $form->field($model, 'thn_pensiun')->textInput() ?>

    <?= $form->field($model, 'status')->radioList(array('0' => 'Tidak Aktif','1' => 'Aktif'))?>

    <?= $form->field($model, 'is_pns')->radioList(array('0' => 'Honorer','1' => 'PNS'))?>

    <?= $form->field($model, 'no_ktp')->textInput(['maxlength' => 16]) ?>

    <?= $form->field($model, 'tgl_masuk')->textInput() ?>

    <?= $form->field($model, 'total_simpanan')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
