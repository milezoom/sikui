<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Anggota */

<<<<<<< HEAD
$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'TransaksiSimpanan', 'url' => ['no_anggota']];
=======
$this->title = 'Detail Anggota : '.$model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Anggota', 'url' => ['nama']];
>>>>>>> origin/master
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-simpanan-view">

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
            'total_simpanan',
            'total_pinjaman',
			'total_simpanan_wajib',
			'total_simpanan_sukarela',
        ],
    ]) ?>

</div>
