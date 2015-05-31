<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserRecord */

$this->title = 'Ubah Password';
$this->params['breadcrumbs'][] = ['label' => 'User Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ubah-password">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'passwordLama')->passwordInput(['maxlength' => 5]) ?>

    <?= $form->field($model, 'passwordBaru')->passwordInput(['maxlength' => 5]) ?>
    
    <?= $form->field($model, 'konfirmasiPassword')->passwordInput(['maxlength' => 5]) ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
