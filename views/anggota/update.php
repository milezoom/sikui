<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Anggota */

$this->title = 'Update Anggota: ' . ' ' . $items[0]->no_anggota;
$this->params['breadcrumbs'][] = ['label' => 'Anggotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $items[0]->no_anggota, 'url' => ['view', 'id' => $items[0]->no_anggota]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="anggota-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formUpdate', [
        'items' => $items
    ]) ?>

</div>
