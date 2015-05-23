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

	<p class ="note">Kolom dengan <span class="required">*</span> wajib diisi.</p>
    
	<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_anggota')->textInput(['maxlength' => 10, 'placeholder' => 'Masukan 10 digit nomor anggota'])->label('Nomor Anggota *') ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => 30, 'placeholder' => 'Nama Anggota'])->label('Nama Anggota *') ?>

    <?= $form->field($model, 'alamat')->textArea(['maxlength' => 150, 'placeholder' => 'Alamat saat ini'])->label('Alamat *') ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => 30, 'placeholder' => 'Nama Anggota']) ?>

    <?= $form->field($model, 'kode_unit')->dropDownList(
		ArrayHelper::map(Unit::find()->all(),'kode','nama'),
		['prompt'=>'Pilih Unit']
	)->label('Kode Unit atau Instansi *') ?>

    <?= $form->field($model, 'tgl_lahir')->textInput(['type' => 'date'])->label('Tanggal Lahir *') ?>

    <?= $form->field($model, 'no_telepon')->textInput(['maxlength' => 15, 'placeholder' => 'No Telp/HP']) ?>

    <?= $form->field($model, 'jenis_kelamin')->dropDownList(['Perempuan' => 'Perempuan','Laki Laki' => 'Laki-laki'])->label('Jenis Kelamin *')?>

    <?= $form->field($model, 'thn_pensiun')->textInput()->label('Tahun Pensiun *') ?>

    <?= $form->field($model, 'status')->dropDownList(['non' => 'Tidak Aktif','aktif' => 'Aktif'])->label('Status Keanggotaan *')?>


    <?= $form->field($model, 'is_pns')->radioList(array('P-UI' => 'Pegawai UI','PNS' => 'PNS'))?>
    
    <?= $form->field($user, 'role')->radioList(array('anggota' => 'Anggota Biasa','admin' => 'Admin Sistem')) ?>

    <?= $form->field($model, 'no_ktp')->textInput(['maxlength' => 16, 'placeholder' => 'Masukan 16 digit Nomor KTP']) ?>

    <?= $form->field($model, 'tgl_masuk')->textInput(['type' => 'date'])->label('Tanggal Masuk *') ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
