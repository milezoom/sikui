<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Anggota */

$this->title = 'Detail Anggota : '.$model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Anggota', 'url' => ['nama']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-simpanan-view">


	<?php if(Yii::$app->session->hasFlash('success')):?>
		<div class="row">	
			<div class="col-xs-6">
				<div class="alert alert-success" role="alert">
					<?php echo Yii::$app->session->getFlash('success'); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if(Yii::$app->session->hasFlash('update')):?>
		<div class="row">	
			<div class="col-xs-6">
				<div class="alert alert-info" role="alert">
					<?php echo Yii::$app->session->getFlash('update'); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update Profil Anggota', ['update', 'id' => $model->no_anggota], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Ubah Status', ['status', 'id' => $model->no_anggota], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'no_anggota',
            'nama',
            'kode_unit',
            'alamat',
            'tgl_lahir',
            'no_telepon',
			'jenis_kelamin',
            'thn_pensiun',
            'status',
            'is_pns',
            'no_ktp',
            'tgl_masuk',
			'total_simpanan_wajib',
			'total_simpanan_sukarela',
            'total_pinjaman',

        ],
    ]) ?>

</div>
