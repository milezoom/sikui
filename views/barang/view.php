<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Barang */

$this->title ='Detail Barang : '.$model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if(Yii::$app->session->hasFlash('success')):?>
	<div class="row">	
		<div class="col-xs-6">
			<div class="alert alert-success" role="alert">
				<?php echo Yii::$app->session->getFlash('success'); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if(Yii::$app->session->hasFlash('update')):?>
	<div class="row">	
		<div class="col-xs-6">
			<div class="alert alert-info" role="alert">
				<?php echo Yii::$app->session->getFlash('update'); ?>
			</div>
		</div>
	</div>
<?php endif; ?>


	
<div class="barang-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->kode], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->kode], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode',
            'nama',
            'harga',
            'img_path',
        ],
    ]) ?>

</div>
