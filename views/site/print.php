<?php
/* @var $this yii\web\View */
$this->title = 'SIKUI';
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
            Bukti Pembayaran Anggota 
          </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4>Untuk: <a href="#">Nama Anggota</a></h4>
            </div>
			<div class="row text-right">
				<div class="col-xs-2">
					<p>
						No Anggota : <br>
						Unit : <br>
						Simp. Wajib : <br>
						Simp. Sukarela : <br>
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
              <h4>Nomor Transaksi</h4>
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
            <td>00000001</td>
            <td>Wajib</td>
            <td class="text-right">Rp. 2.000.000,00</td>
            <td>Simpanan Wajib Bulan Januari-September</td>  
          </tr>
        </tbody>
      </table>
      <div class="row">
        <div class="col-xs-12">
          <strong>
          TERBILANG : DUA JUTA RUPIAH <br><br><br><br>
          </strong>
        </div>
      </div>
	  <div class="row">
        <div class="col-xs-5">
          <br>Petugas Koperasi <br><br><br>
		  Nama Petugas
        </div>
		<div class="col-xs-5 col-xs-offset-2 text-right">
          Tanggal<br>
		  Penyetor <br><br><br>
		  Nama Penyetor
        </div>
      </div>
    </div>
        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>