<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="<?= Yii::$app->request->getBaseUrl()?>/css/login.css">
<div class="site-login">
    <div class  ='row'>
        <div id="logmsk">
            <div id="userbox">
                <h1 id="signup">
                    Sistem Informasi KPR-UI
                </h1>
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'username',['options' => ['id' => 'name']]) ?>
                <?php echo "<br/>"?>
                <?= $form->field($model, 'password',['options' => ['id' => 'pass']])->passwordInput() ?>
                <?= Html::submitButton('Masuk',['id' => 'signupb']) ?>
                <?php ActiveForm::end(); ?>
                <h1 id="credit">
                    &copy; Propensi C05 &amp; KPR-UI
                </h1>
            </div>            
        </div>
    </div>
</div>
