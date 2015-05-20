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

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($items[0], 'nama')->textInput(['maxlength' => 30, 'placeholder' => 'Nama Anggota']) ?>
	
    <?= $form->field($items[0], 'kode_unit')->dropDownList(
		ArrayHelper::map(Unit::find()->all(),'kode','nama'),
		['prompt'=>'Pilih Unit']
	) ?>

    <?= $form->field($items[0], 'alamat')->textArea(['maxlength' => 150, 'placeholder' => 'Alamat saat ini']) ?>

    <?= $form->field($items[0], 'tgl_lahir')->textInput(['type' => 'date']) ?>

    <?= $form->field($items[0], 'no_telepon')->textInput(['maxlength' => 15, 'placeholder' => 'No Telp/HP']) ?>

    <?= $form->field($items[0], 'jenis_kelamin')->radioList(array('0' => 'Perempuan','1' => 'Laki-laki'))?>

    <?= $form->field($items[0], 'thn_pensiun')->textInput() ?>

    <?= $form->field($items[0], 'status')->radioList(array('0' => 'Tidak Aktif','1' => 'Aktif'))?>

    <?= $form->field($items[0], 'is_pns')->radioList(array('0' => 'Honorer','1' => 'PNS'))?>
    
    <?= $form->field($items[1], 'role')->radioList(array('anggota' => 'Anggota Biasa','admin' => 'Admin Sistem')) ?>

    <?= $form->field($items[0], 'no_ktp')->textInput(['maxlength' => 16, 'placeholder' => 'Masukan 16 digit Nomor KTP']) ?>
	
    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
