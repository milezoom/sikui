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
   
	<?= $form->field($model, 'kode_barang')->dropDownList(
		ArrayHelper::map(Barang::find()->all(),'kode','nama'),
		['prompt'=>'Select Barang']
	) ?>

    <?= $form->field($model, 'kode_pinjaman')->textInput(['maxlength' => 4]) ?>
	
	<?= $form->field($model, 'kode_barang')->dropDownList(
		ArrayHelper::map(Barang::find()->all(),'kode','nama'),
		['prompt'=>'Select Barang']
	) ?>

    <?= $form->field($model, 'no_anggota') ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>
	
    <?= $form->field($model, 'tgl_pinjam')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'jatuh_tempo')->textInput(['type' => 'date']) ?>    
	
	<?= $form->field($model, 'banyak_angsuran')->radioList(array('5' => '5 kali','10' => '10 kali', '15' => '15 kali'))?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?= Html::a('Batal', ['daftar'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
