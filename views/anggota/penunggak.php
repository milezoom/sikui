<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnggotaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Penunggak Pinjaman';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggota-peunggak">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'no_anggota',
        'nama',
        'alamat',
        'total_simpanan',
        'total_pinjaman',       
    ],
]); ?>

</div>
