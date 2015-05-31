<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\Anggota */


$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Anggotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggota-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Ubah Password', ['/site-anggota/ubah-password'], ['class' => 'btn btn-primary']) ?>
    
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
