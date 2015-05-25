<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Anggota */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Anggota', 'url' => ['nama']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggota-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?= Html::a('Tambah Simpanan Wajib', ['wajib','id'=> $model->no_anggota], ['class' => 'btn btn-success']) ?>
		<?= Html::a('Tambah Simpanan Sukarela', ['sukarela', 'id'=> $model->no_anggota], ['class' => 'btn btn-success']) ?>
		<?= Html::a('Ambil Simpanan', ['ambil', 'id'=> $model->no_anggota], ['class' => 'btn btn-success']) ?>
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
            'thn_pensiun',
            'is_pns:boolean',
            'tgl_masuk',
            'total_simpanan',
			'total_simpanan_wajib',
			'total_simpanan_sukarela'
        ],
    ]) ?>

</div>
