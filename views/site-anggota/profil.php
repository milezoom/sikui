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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'no_anggota',
            'nama',
            'kode_unit',
            'alamat',
            'tgl_lahir',
            'no_telepon',
            'jenis_kelamin:boolean',
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
