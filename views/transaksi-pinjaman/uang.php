<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TransaksiPinjaman */

$this->title = 'Tambah Pinjaman Uang';

$this->params['breadcrumbs'][] = ['label' => 'Tambah Pinjaman Uang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-pinjaman-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_formUang', [
        'model' => $model,
    ]) ?>

</div>
