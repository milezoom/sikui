<?php
/* @var $this yii\web\View */
$this->title = 'Kuitansi';
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <?php $this->head() ?>
        <link rel="stylesheet" href="<?= Yii::$app->request->getBaseUrl()?>/css/bootstrap.css">
        <link rel="stylesheet" href="<?= Yii::$app->request->getBaseUrl()?>/css/site.css">
    </head>
    <body>        
        <?php $this->beginBody() ?>
        <div class="container">
			<div class="row">
				<div class="col-xs-6">
					<h1>
					Kuitansi Pembayaran Simpanan 
					</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Untuk: <?php echo $nama	 ?></h4>
						</div>
						<div class="row ">
							<div class="col-xs-2 text-right">
								<p>
									No Anggota : <br> 
									Unit : <br>
									Simp. Wajib : <br>
									Simp. Sukarela : <br>
								</p>
							</div>
							<div class="col-xs-7">
								<p>
									<?php echo $no_anggota ?><br>
									<?php echo $nama_unit ?><br>
									<?php echo $wajib ?><br>
									<?php echo $sukarela ?><br>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- / end client details section -->
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>
							<h4>Kode Transaksi</h4>
						</th>
						<th>
							<h4>Jenis Simpanan</h4>
						</th>
						<th>
							<h4>Total Bayar</h4>
						</th>
						<th>
							<h4>Keterangan</h4>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $kode_trans ?></td>
						<td><?php echo $jenis ?></td>
						<td class="text-right">Rp.<?php echo $jumlah ?></td>
						<td><?php echo $keterangan ?></td>  
					</tr>
				</tbody>
			</table>
			<div class="row">
				<div class="col-xs-12">
					<strong>
						TERBILANG :  <br><br><br><br>
					</strong>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-5">
					<br>
					Petugas Koperasi <br><br><br>
					Nama Petugas
				</div>
				<div class="col-xs-5 col-xs-offset-2 text-right">
					<?php echo $tanggal ?><br>
					Penyetor <br><br><br>
					Nama Penyetor
				</div>
			</div>
		</div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>