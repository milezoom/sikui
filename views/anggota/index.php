<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnggotaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anggotas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggota-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Anggota', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_anggota',
            'nama',
            'kode_unit',
            'alamat',
            'tgl_lahir',
            // 'no_telepon',
            // 'jenis_kelamin:boolean',
            // 'thn_pensiun',
            // 'status:boolean',
            // 'is_pns:boolean',
            // 'no_ktp',
            // 'tgl_masuk',
            // 'total_simpanan',
            // 'total_pinjaman',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
