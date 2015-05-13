<?php
/* @var $this yii\web\View */
$this->title = 'SIKUI';
?>
<div class="site-index">
    <h2>Selamat Datang</h2>
		<div class="homecontent">
        <div class="row">
			<div class="col-xs-1">
			</div>
			<div class="col-lg-4 kotak">
				<img src="<?= Yii::$app->request->getBaseUrl() ?>/logos/user.png" width = "125" height ="125">
				<br>
                <text>756 anggota terdaftar</text>
            </div>
			<div class="col-xs-1">
			</div>
            <div class="col-lg-4 kotak">
				<img src="<?= Yii::$app->request->getBaseUrl() ?>/logos/simpan.png" width = "125" height ="125">
				<br>
                <text>Rp 200.000.000 ,- tersimpan</text>
            </div>
			<div class="col-xs-1">
			</div>
            <div class="col-lg-4 kotak">
				<img src="<?= Yii::$app->request->getBaseUrl() ?>/logos/pinjam.png" width = "125" height ="125">
				<br>
                <text>Rp 10.000.000 ,- dipinjam </text>
            </div>
        </div>
		<br>
		<div class="row">
			<div class="col-lg-3">
			</div>
            <div class="col-lg-3 kotak">
				<img src="<?= Yii::$app->request->getBaseUrl() ?>/logos/stat.png" width = "125" height ="125">
				<br>
                <text>Rp 125.000.000 ,- diperoleh</text>
            </div>
			<div class="col-lg-1">
			</div>
            <div class="col-lg-3 kotak">
				<img src="<?= Yii::$app->request->getBaseUrl() ?>/logos/alert.png" width = "125" height ="125">
				<br>
                <text>2 anggota menunggak</text>
            </div>
        </div>
</div>