<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiSimpanan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-simpanan-form">

    <?php $form = ActiveForm::begin(); ?>
   
	<?= $form->field($model, 'kode_simpanan')-> textInput(['value' => 'SPSKRL', 'readonly'=>true]) -> label('Kode Simpanan*')?>

    <?= $form->field($model, 'tanggal')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'no_anggota')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?= Html::a('Batal', ['daftar'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
