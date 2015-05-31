<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div>
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <br/>
    <p><em>Jika anda sudah mengikuti cara di user manual, namun tetap terjadi error, mohon beritahu pengurus koperasi.</em></p>

</div>
