<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Anggota */

$this->title = $model->no_anggota;
$this->params['breadcrumbs'][] = ['label' => 'Anggota', 'url' => ['nama']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggota-profil">

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