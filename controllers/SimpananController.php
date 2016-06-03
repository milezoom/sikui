<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: SimpananController.php
*/

namespace app\controllers;

use Yii;
use yii\web\Controller;

use app\models\Simpanan;
use app\models\SiteVariable;
use app\models\Anggota;

/**
 * Kelas controller khusus fungsi
 * berkaitan dengan data transaksi simpanan.
 */
class SimpananController extends Controller
{
    /**
    * RBAC rule untuk fungsi-fungsi di controller ini.
    * @return array rule RBAC
    */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],
                'rules' => [
                    'actions' => [],
                    'allow' => true,
                    'matchCallback' => function($rule,$action)
                    {
                        $role = Yii::$app->user->isGuest ? 'guest' : Yii::$app->user->identity->role;
                        return $role == "admin";
                    },
                ],
            ],
        ];
    }

    /**
    * Action umum yang berlaku bagi controller ini.
    * @return array daftar action
    */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
    * Menambah transaksi simpanan baru ke database.
    * @return object halaman view yang terkait
    */
    public function actionTambah()
    {
        $simpanan = new Simpanan();

        //set value default untuk beberapa attribut
        $simpanan->tanggal = date('Y-m-d');
        $simpanan->simpanan_wajib = SiteVariable::getSimpananWajib();
        $simpanan->dana_sosial = SiteVariable::getDanaSosial();
        $simpanan->simpanan_sukarela = $simpanan->shu = 0;

        //selector untuk anggota
        $anggota = Anggota::find()->orderBy('no_anggota,kode_unit,nama')->all();
        $listAnggota = array();
        foreach ($anggota as $data) {
            $listAnggota[$data->no_anggota] = $data->nama.' - '.$data->getUnit()->nama;
        }

        if($simpanan->load(Yii::$app->request->post()) && $simpanan->save())
        {
            $session = Yii::$app->session;
            $session->setFlash('simpanan', 'Simpanan berhasil ditambahkan.');
            $dataArray = array(
                'tipe'=>'tambah',
                'nomor'=>$simpanan->no_anggota,
                'wajib'=>$simpanan->simpanan_wajib,
                'sukarela'=>$simpanan->simpanan_sukarela,
                'sosial' =>$simpanan->dana_sosial,
            );
            $coded = urlencode(base64_encode(serialize($dataArray)));
            $session->setFlash('transfer-data',$coded);
            return $this->redirect('list',['tanggal'=>date('Y-m')]);
        }

        return $this->render('form', [
            'model' => $simpanan,
            'anggota' => $listAnggota,
            'title' => 'Tambah Simpanan',
        ]);

    }

    /**
    * Menampilkan transaksi simpanan pada bulan dan tahun tertentu
    * dalam bentuk tabular.
    * @param string $tanggal tanggal dalam format yyyy-mm
    * @return object halaman view yang terkait
    */
    public function actionList($tanggal)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date_create($tanggal);

        //membuat data provider
        $query = new Query();
        $query = Simpanan::find()
        ->where(['>=','tanggal',date_format($date,'Y-m-d')])
		->andWhere(['<=','tanggal',date_format($date,'Y-m-t')]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pagesize'=>25],
            'sort' => ['attributes' => ['id']],
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'title' => 'Transaksi Simpanan Bulan '.
                getNamaBulan(intval(date_format($date,'m'))).
                ' Tahun '.date_format($date,'Y'),
        ]);
    }

    public function actionListPenunggak($sort='nomor',$search='')
    {
        
    }

    public function actionAmbil()
    {
        # code...
    }

    public function actionTambahDariCsv()
    {
        # code...
    }

    public function actionRekapKeCsv()
    {
        # code...
    }

    /**
    * Mencari model data simpanan dengan id tertentu.
    * @param integer $id nomor transaksi simpanan
    * @return Simpanan model data simpanan
    */
    protected function findModel($id)
    {
        if (($model = Simpanan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Halaman yang diminta tidak ditemukan.');
        }
    }

    /**
    * Memberikan nama bulan sesuai dengan format angka bulan input.
    * @param integer $bulan bulan dalam format angka
    * @return string nama bulan
    */
    private function getNamaBulan($bulan)
    {
        switch (intval($bulan)) {
            case 1:
                return 'Januari'; break;
            case 2:
                return 'Februari'; break;
            case 3:
                return 'Maret'; break;
            case 4:
                return 'April'; break;
            case 5:
                return 'Mei'; break;
            case 6:
                return 'Juni'; break;
            case 7:
                return 'Juli'; break;
            case 8:
                return 'Agustus'; break;
            case 9:
                return 'September'; break;
            case 10:
                return 'Oktober'; break;
            case 11:
                return 'November'; break;
            case 12:
                return 'Desember'; break;
            default:
                return; break;
        }
    }
}

?>
