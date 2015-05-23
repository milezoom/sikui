<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransaksiSimpananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Transaksi Simpanan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-simpanan-index">


	<?php if(Yii::$app->session->hasFlash('success')):?>
		<div class="row">	
			<div class="col-xs-6">
				<div class="alert alert-success" role="alert">
					<?php echo Yii::$app->session->getFlash('success'); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_trans',
            'kode_simpanan',
            'tanggal',
            'no_anggota',
            'jumlah',
            // 'keterangan',

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
