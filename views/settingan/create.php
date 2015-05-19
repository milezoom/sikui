<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Settingan */

$this->title = 'Create Settingan';
$this->params['breadcrumbs'][] = ['label' => 'Settingans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settingan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
