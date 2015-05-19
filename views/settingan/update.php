<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Settingan */

$this->title = 'Ubah Simpanan Pokok';
$this->params['breadcrumbs'][] = ['label' => 'Settingans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->key, 'url' => ['view', 'id' => $model->key]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="settingan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div>
		<label class="control-label" for="anggota-no_anggota">Simpanan Pokok Terakhir</label>
	</div>
	<div>
		<label class="label-konten"><?= Html::encode($model->value); ?></label>
	</div>
	
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
