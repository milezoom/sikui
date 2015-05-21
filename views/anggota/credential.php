<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Anggota */

$this->title = 'Username dan Password';
$this->params['breadcrumbs'][] = ['label' => 'Anggota', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggota-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Data anggota baru berhasil disimpan. Berikut adalah username dan password untuk anggota tersebut.</p>
    <h3>Username : <?php echo $username; ?> </h3>
    <h3>Password : <?php echo $password; ?> </h3>
    <p>
        <em>
            Mohon hati-hati dalam menyimpan informasi tersebut.
            <br/>
            Informasi tersebut digunakan untuk masuk sistem.
        </em>
    </p>
</div>
