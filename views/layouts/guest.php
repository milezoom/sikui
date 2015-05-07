<?php
use yii\helpers\Html;
use yii\widgets\Menu;

/* @var $this \yii\web\View */
/* @var $content string */

\yii\web\YiiAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link rel="stylesheet" href="<?= Yii::$app->request->getBaseUrl()?>/css/bootstrap.css">
        <link rel="stylesheet" href="<?= Yii::$app->request->getBaseUrl()?>/css/site.css">
    </head>
    <body>
		<?php $this->beginBody() ?>
			<div class="container">			
				<div class="header">
					<table>
						<tr><td></td></tr>
						<tr>
							<td class="header-left">
								<img class="img-responsive logo-header" 
									 src="<?= Yii::$app->request->getBaseUrl()?>/logos/sikui.png" alt="logo-sikui">
							</td>  
							<td class="header-center">
								<h2>
									SIKUI<br/>
									<small>Sistem Informasi Koperasi UI</small>
								</h2>
							</td>
							<td class="header-right">
								<img class="img-responsive logo-header" 
									 src="<?= Yii::$app->request->getBaseUrl()?>/logos/koperasi.png" alt="logo-koperasi">
							</td>
						</tr>
						<tr><td></td></tr>
					</table>
				</div>
				<div class="content">
					<?= $content ?>
				</div>
			<footer class="footer">
				<div class="container">
					<p class="text-center">&copy; Propensi C05 <?= date('Y') ?>, <?= Yii::powered() ?></p>
				</div>
			</footer>
		</div>
        <?php $this->endBody() ?>

        <script src="<?= Yii::$app->request->getBaseUrl()?>/js/jquery-1.11.2.min.js"></script>
        <script src="<?= Yii::$app->request->getBaseUrl()?>/js/bootstrap.js"></script>
    </body>
</html>
<?php $this->endPage() ?>