<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TransaksiPinjaman */

$this->title = 'Update Transaksi Pinjaman: ' . ' ' . $model->kode_trans;
$this->params['breadcrumbs'][] = ['label' => 'Transaksi Pinjamen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode_trans, 'url' => ['view', 'id' => $model->kode_trans]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transaksi-pinjaman-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
