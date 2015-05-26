<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransaksiSimpananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Riwayat Transaksi Pinjaman';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-pinjaman-index">
	
	
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_trans',
            'kode_pinjaman',
            'tgl_pinjam',
			'sisa_piutang',
            //'jumlah',
            // 'keterangan',
			
			['class' => 'yii\grid\ActionColumn',
                          'template'=>'{indeks}',
                            'buttons'=>[
                              'indeks' => function ($url, $model) {     
                                return Html::a('<span >Bayar</span>', $url, [
                                        'title' => Yii::t('yii', 'Bayar Pinjaman'),
										'class' => 'btn btn-success'
                                ]);                                
                              }
							]                            
            ],
			
			
        ],
		
		
    ]); ?>

</div>
