<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class  ='row'>
	
	<div class ='col-lg-3'>
	</div>
	<div class ='col-lg-3 kotaklog'>
    <p>Silahkan masukkan username dan password anda:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>


    <?= Html::submitButton('Login') ?>

    <?php ActiveForm::end(); ?>
	</div>
	<div class ='col-lg-1'>
	</div>
	</div>
</div>
