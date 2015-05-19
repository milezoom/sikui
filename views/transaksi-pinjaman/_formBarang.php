<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Barang;
use app\models\Anggota;


/* @var $this yii\web\View */
/* @var $model app\models\TransaksiPinjaman */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-pinjaman-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_trans')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'kode_pinjaman')->textInput(['value'=> 'PJBG', 'readonly' => true]) ?>

   <?= $form->field($model, 'no_anggota')->dropDownList(
		ArrayHelper::map(Anggota::find()->all(),'no_anggota','nama'),
		['prompt'=>'Select Anggota']
	) ?>
	
	<?= $form->field($model, 'kode_barang')->dropDownList(
		ArrayHelper::map(Barang::find()->all(),'kode','nama'),
		['prompt'=>'Select Barang']
	) ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <?= $form->field($model, 'sisa_piutang')->textInput() ?>

    <?= $form->field($model, 'tgl_pinjam')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'jatuh_tempo')->textInput(['type' => 'date']) ?>    
	
	<?= $form->field($model, 'banyak_angsuran')->radioList(array('5' => '5 kali','10' => '10 kali', '15' => '15 kali'))?> 

    <?= $form->field($model, 'denda')->textInput(['value'=> 0]) ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
