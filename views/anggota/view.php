<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Anggota */

$this->title = 'Detail Anggota : '.$model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Anggota', 'url' => ['nama']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggota-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update Anggota', ['update', 'id' => $model->no_anggota], ['class' => 'btn btn-primary']) ?>
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
            'thn_pensiun',
            'status:boolean',
            'is_pns:boolean',
            'no_ktp',
            'tgl_masuk',
            'total_simpanan',
            'total_pinjaman',
        ],
    ]) ?>

</div>
