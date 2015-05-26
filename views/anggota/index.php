<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnggotaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Anggota Koperasi Rektorat UI';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggota-index">

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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Anggota Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'no_anggota',
        'nama',
        //'kode_unit',
        //'alamat',
        //'tgl_lahir',
        'total_simpanan',
        'total_pinjaman',
        ['class' => 'yii\grid\ActionColumn',
         'template'=>'{view}',
         'buttons'=>[
             'view' => function ($url, $model) {     
                 return Html::a('<span >Lihat</span>', $url, [
                     'title' => Yii::t('yii', 'Lihat Transaksi'),
                     'class' => 'btn btn-success',
                 ]);                                
             }                                
         ]                            
        ],
    ],
]); ?>

</div>
