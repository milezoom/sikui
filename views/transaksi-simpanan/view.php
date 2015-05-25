<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiSimpanan */

$this->title = 'Detail Transaksi Simpanan '.$model->kode_trans;
$this->params['breadcrumbs'][] = ['label' => 'Simpanan Anggota', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transaksi-simpanan-view">


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

    <p>
		<?= Html::a('Print Simpanan', ['print-kuitansi', 'id' => $model->kode_trans], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode_trans',
            'kode_simpanan',
            'no_anggota',
            'jumlah',
			'tanggal',
			'keterangan',
        ],
    ]) ?>

</div>
