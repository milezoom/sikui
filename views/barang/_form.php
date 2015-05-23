<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Barang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'kode')->textInput(['maxlength' => 10, 'placeholder' => 'Masukan Kode Barang']) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => 30, 'placeholder' => 'Nama Barang']) ?>

    <?= $form->field($model, 'harga')->textInput(['placeholder' => 'Harga Barang']) ?>

    <?= $form->field($model, 'img_path')->textInput(['maxlength' => 150]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?= Html::a('Batal', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
