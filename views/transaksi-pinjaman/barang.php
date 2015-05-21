<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TransaksiPinjaman */

$this->title = 'Tambah Pinjaman Barang';
$this->params['breadcrumbs'][] = ['label' => 'Transaksi Pinjamen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-pinjaman-create">

    <h1><?= Html::encode($this->title) ?></h1>
	<p>Keterangan :<strong> * is required</strong></p>

    <?= $this->render('_formBarang', [
        'model' => $model,
    ]) ?>

</div>
