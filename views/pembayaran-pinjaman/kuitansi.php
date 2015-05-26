<?php
/* @var $this yii\web\View */
$this->title = 'Angsuran';
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
					Kuitansi Pembayaran Pinjaman 
					</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Detail Pembayar</a></h4>
						</div>
						<div class="panel-body col-xs-2">
								<p>
									Nama  <br>
									Unit  <br>
								</p>
						</div>
						<div class="panel-body col-xs-4">
								<p>
									: <?php echo $nama	 ?> <br>
									: <?php echo $nama_unit ?><br>
								</p>
						</div>
						
					</div>
				</div>
				<div class="col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Detail Peminjaman</a></h4>
						</div>
						<div class="panel-body col-xs-2">
								<p>
									Jenis Pinjaman  <br>
									Jumlah Pinjam <br>
									Jumlah Angsuran  <br>
								</p>
						</div>
						<div class="panel-body col-xs-4">
								<p>
									: <?php echo $jenis ?><br>
									: <?php echo $jumlah_pinjam ?><br>
									: <?php echo $banyak_angsuran ?><br>
								</p>
						</div>
					</div>
				</div>
			</div>
			<!-- / end client details section -->
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>
							<h4>No. Trans</h4>
						</th>
						<th>
							<h4>Tanggal</h4>
						</th>
						<th>
							<h4>Angsuran ke-</h4>
						</th>
						<th>
							<h4>Pokok</h4>
						</th>
						<th>
							<h4>Jasa</h4>
						</th>
						<th>
							<h4>Denda</h4>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $kode_pinjam ?></td>
						<td><?php echo $tanggal ?></td>
						<td><?php echo $no_angsuran ?></td>
						<td class="text-right">Rp. <?php echo $jumlah ?>,00</td>
						<td class="text-right">Rp. <?php echo $jasa ?>,00</td>
						<td class="text-right">Rp. <?php echo $denda ?>,00	</td>  
					</tr>
				</tbody>
			</table>
			<div class="row">
				<div class="col-xs-12">
					<strong>
						TERBILANG : DUA JUTA RUPIAH <br><br>
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
					......,  ...-...-.....<br>
					Penyetor <br><br><br>
					Nama Penyetor
				</div>
			</div>
		</div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>