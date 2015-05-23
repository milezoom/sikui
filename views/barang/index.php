<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Barang';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="barang-index">

<?php if(Yii::$app->session->hasFlash('delete')):?>
	<div class="row">	
		<div class="col-xs-6">
			<div class="alert alert-danger" role="alert">
				<?php echo Yii::$app->session->getFlash('delete'); ?>
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

            'kode',
            'nama',
            'harga',
            'img_path',

            ['class' => 'yii\grid\ActionColumn',
                          'template'=>'{view}',
                            'buttons'=>[
                              'view' => function ($url, $model) {     
                                return Html::a('<span >Lihat</span>', $url, [
                                        'title' => Yii::t('yii', 'Lihat Transaksi'),
										'class' => 'btn btn-success'
                                ]);                                
                              }
							]                            
            ],
			
			['class' => 'yii\grid\ActionColumn',
                          'template'=>'{update}',
                            'buttons'=>[
                              'update' => function ($url, $model) {     
                                return Html::a('<span >Ubah</span>', $url, [
                                        'title' => Yii::t('yii', 'Ubah Transaksi'),
										'class' => 'btn btn-success'
                                ]);                                
                              }
							]                            
            ],
			
        ],
    ]); ?>

</div>
