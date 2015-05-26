<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Unit;

/* @var $this yii\web\View */
/* @var $model app\models\Anggota */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anggota-form">
	
	<p class ="note"> <br> Kolom dengan <span class="required">*</span> wajib diisi.</p>
	
    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'nama')->textInput(['maxlength' => 30, 'placeholder' => 'Nama Anggota']) ?>
	
    <?= $form->field($model, 'kode_unit')->dropDownList(
		ArrayHelper::map(Unit::find()->all(),'kode','nama'),
		['prompt'=>'Pilih Unit']
	) ?>

    <?= $form->field($model, 'alamat')->textArea(['maxlength' => 150, 'placeholder' => 'Alamat saat ini']) ?>

    <?= $form->field($model, 'tgl_lahir')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'jenis_kelamin')->radioList(array('Perempuan' => 'Perempuan','Laki-laki' => 'Laki-laki'))?>

    <?= $form->field($model, 'thn_pensiun')->textInput()?>

    <?= $form->field($model, 'is_pns')->radioList(array('P-UI' => 'Pegawai UI','PNS' => 'PNS'))?>
    
    <?= $form->field($user, 'role')->radioList(array('anggota' => 'Anggota Biasa','admin' => 'Admin Sistem')) ?>

    <?= $form->field($model, 'no_ktp')->textInput(['maxlength' => 16, 'placeholder' => 'Masukan 16 digit Nomor KTP']) ?>
	
    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
