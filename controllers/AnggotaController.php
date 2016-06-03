<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: AnggotaController.php
*/

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\base\DynamicModel;
use yii\web\NotFoundHttpException;

use app\models\Anggota;
use app\models\User;
use app\models\Unit;
use app\models\SiteVariable;

/**
 * Kelas controller khusus fungsi
 * berkaitan dengan data anggota.
 */
class AnggotaController extends Controller
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
                'only' => ['tambah','detail','ubah','hapus','list','pesan'],
                'rules' => [
                    'actions' => ['tambah','detail','ubah','hapus','list','pesan'],
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
    * Menambah anggota baru ke database.
    * @return object halaman view yang terkait
    */
    public function actionTambah()
    {
        $anggota = new Anggota();
        $anggota->tgl_masuk = date('Y-m-d');

        $user = new User();

        //selector untuk unit kerja
        $unit = Unit::find()->all();
        $listUnit = ArrayHelper::map($unit,'kode_unit','nama_unit');

        //selector untuk jenis kelamin
        $jenisKelamin = [
            'Laki-laki' => 'Laki-laki',
            'Perempuan' => 'Perempuan',
        ];

        //selector untuk tahun pensiun
        date_default_timezone_set('Asia/Jakarta');
        $yearRange = strtotime('+100 years');
        $range = range(date('Y'),date('Y',$yearRange));
        $listTahunPensiun = array_combine($range,$range);

        //selector untuk pegawai pns
        $listPNS = [
            'ya' => 'Ya',
            'tidak' => 'Tidak',
        ];

        //selector untuk role di sistem
        $listRole = [
            'anggota' => 'Anggota Biasa',
            'admin' => 'Admin Sistem',
        ];

        $teksDiatasForm = 'Simpanan Pokok, Wajib, & Dana Sosial pertama akan ditambahkan otomatis.';

        if($anggota->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())
            && $anggota->validate())
        {
            //memproses data anggota untuk disimpan
            if($anggota->tgl_lahir !== '')
            {
                $tglLahir = str_replace('/','-',$anggota->tgl_lahir);
                $anggota->tgl_lahir = date('Y-m-d',$tglLahir);
            }
            $anggota->save(false); //simpan tanpa validasi ulang
            //simpanan pokok, wajib, & dana sosial ditambahkan otomatis
            //dengan procedure di database

            //memproses data user untuk disimpan
            $user->no_anggota = $anggota->no_anggota;
            $userCredential = createCredential($anggota->no_anggota, $anggota->nama);
            $user->username = $userCredential['username'];
            $user->password = $userCredential['password'];
            $user->save();

            //flash message dan passing data untuk kuitansi
            $session = Yii::$app->session;
            $session->setFlash('anggota','Anggota baru berhasil ditambahkan.');
            $dataArray = array(
                'tipe' => 'tambah',
                'nomor' => $anggota->no_anggota,
                'pokok' => SiteVariable::getSimpananPokok(),
                'wajib' => SiteVariable::getSimpananWajib(),
                'sosial' => SiteVariable::getDanaSosial(),
            );
            $coded = urlencode(base64_encode(serialize($dataArray)));
            $session->setFlash('transfer-data',$coded);

            return $this->redirect('list');
        }

        return $this->render('form',[
            'modelAnggota' => $anggota,
            'modelUser' => $user,
            'unit' => $unit,
            'jenisKelamin' => $jenisKelamin,
            'pensiun' => $listTahunPensiun,
            'pns' => $listPNS,
            'role' => $listRole,
            'text' => $teksDiatasForm,
            'title' => 'Tambah Anggota Baru',
            'button' => 'Simpan',
        ]);
    }

    /**
    * Melihat detail data anggota dengan nomor anggota tertentu.
    * @param integer $id nomor anggota
    * @return object halaman view yang terkait
    */
    public function actionDetail($id)
    {
        $model = findModel($id);
        $unit = $model->getUnit()->nama;
        return $this->render('detail', [
            'model'=> $model,
            'unit' => $unit,
            'title' => 'Detail Data Anggota no '.$model->no_anggota,
        ]);
    }

    /**
    * Mengubah data anggota dengan nomor anggota tertentu.
    * @param integer $id nomor anggota
    * @return object halaman view yang terkait
    */
    public function actionUbah($id)
    {
        $anggota = findModel($id);
        $user = $anggota->getUser();

        //konversi beberapa atribut agar sama dengan format pada view
        if($anggota->tgl_lahir !== '')
        {
            $anggota->tgl_lahir = date('d/m/Y',strtotime($anggota->tgl_lahir));
        }

        //selector untuk unit kerja
        $unit = Unit::find()->all();
        $listUnit = ArrayHelper::map($unit,'kode_unit','nama_unit');

        //selector untuk jenis kelamin
        $jenisKelamin = [
            'Laki-laki' => 'Laki-laki',
            'Perempuan' => 'Perempuan',
        ];

        //selector untuk tahun pensiun
        date_default_timezone_set('Asia/Jakarta');
        $yearRange = strtotime('+100 years');
        $range = range(date('Y'),date('Y',$yearRange));
        $listTahunPensiun = array_combine($range,$range);

        //selector untuk pegawai pns
        $listPNS = [
            'ya' => 'Ya',
            'tidak' => 'Tidak',
        ];

        //selector untuk role di sistem
        $listRole = [
            'anggota' => 'Anggota Biasa',
            'admin' => 'Admin Sistem',
        ];

        if($anggota->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())
            && $anggota->validate() && $user->save())
        {
            //memproses data anggota untuk disimpan
            if($anggota->tgl_lahir !== '')
            {
                $tglLahir = str_replace('/','-',$anggota->tgl_lahir);
                $anggota->tgl_lahir = date('Y-m-d',$tglLahir);
            }
            $anggota->save(false); //simpan tanpa validasi ulang

            //flash message
            $session = Yii::$app->session;
            $session->setFlash('anggota','Data anggota berhasil diubah.');

            return $this->redirect('list');
        }

        return $this->render('form',[
            'modelAnggota' => $anggota,
            'modelUser' => $user,
            'unit' => $unit,
            'jenisKelamin' => $jenisKelamin,
            'pensiun' => $listTahunPensiun,
            'pns' => $listPNS,
            'role' => $listRole,
            'title' => 'Ubah Data Anggota no. '.$anggota->no_anggota,
            'button' => 'Simpan',
        ]);
    }

    /**
    * Menghapus data anggota dengan nomor anggota tertentu.
    * @param integer $id nomor anggota
    * @return object halaman view yang terkait
    */
    public function actionHapus($id)
    {
        $model = findModel($id);
        $model->delete();
        Yii::$app->getSession()->setFlash('anggota', 'Anggota berhasil dihapus.');
        return $this->redirect('list');
    }

    /**
    * Menampilkan daftar anggota dalam bentuk tabular.
    * @param string $sort kriteria untuk mengurutkan
    * @param string $search teks untuk dicari pada daftar anggota
    * @return object halaman view yang terkait
    */
    public function actionList($sort='nomor',$search='')
    {
        //model untuk menangkap search string dari view
        $modelSearch = DynamicModel::validateData(compact('search'),[
            ['search','string'],
        ]);

        //model untuk menangkap opsi sort yang dipilih dari view
        $modelSort = DynamicModel::validateData(compact('sort'),[
            ['sort','string'],
        ]);

        //selector untuk opsi sort
        $listSortOption = array(
            'nomor'=>'Nomor Anggota',
            'nama'=>'Nama Anggota',
            'simpanan'=>'Total Simpanan',
            'pinjaman'=>'Total Pinjaman',
        );

        //load data ke model dan kembalikan ke fungsi yang sama
        //untuk mengaplikasikan search string dan opsi sort yang dipilih
		if($modelSearch->load(Yii::$app->request->post()) &&
        $modelSort->load(Yii::$app->request->post())) {
            $sort = $modelSort->sort;
            $search = $modelSearch->search;
            return $this->redirect(['list','search'=>$search,'sort'=>$sort]);
        }

        //membuat query ke database untuk dipakai oleh data provider
        $query = Anggota::find()->where(['status'=>'aktif']);
        if($search !== '') {
            $query = Anggota::find()->where(['status'=>'aktif'])
				->andWhere(['LIKE','nama',$search])
				->orWhere(['LIKE','nama',ucwords($search)]);
        }

        //membuat data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pagesize'=>25],
            'sort' => ['attributes' => ['nomor']],
        ]);

        //assign opsi sort yang dipilih ke data provider
        switch ($modelSort->sort) {
            case 'nomor':
                $dataProvider->setSort([
                    'defaultOrder' => ['no_anggota' => SORT_ASC],
                ]); break;
            case 'nama':
                $dataProvider->setSort([
                    'defaultOrder' => ['nama' => SORT_ASC],
                ]); break;
            case 'simpanan':
                $dataProvider->setSort([
                    'defaultOrder' => ['total_simpanan' => SORT_ASC],
                ]); break;
            case 'pinjaman':
                $dataProvider->setSort([
                    'defaultOrder' => ['total_pinjaman' => SORT_ASC],
                ]); break;
            default:
                $dataProvider->setSort([
                    'defaultOrder' => ['no_anggota' => SORT_ASC],
                ]); break;
        }

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'modelSearch' => $modelSearch,
            'modelSort' => $modelSort,
            'listSortOption' => $listSortOption,
            'title' => 'Daftar Anggota di Koperasi',
        ]);
    }

    /**
    * Mengirim pesan ke anggota dengan nomor anggota tertentu.
    * @param integer $id nomor anggota
    * @return object halaman view terkait
    */
    public function actionPesan($id)
    {
        $model = findModel($id);

        if($model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->getSession()->setFlash('anggota', 'Pesan berhasil dikirim ke anggota.');
            return $this->redirect('list');
        }

        return $this->render('ubah-pesan',[
            'model' => $model,
            'title' => 'Kirim Pesan ke Anggota',
        ]);
    }

    /**
    * Mencari model data anggota dengan id tertentu.
    * @param integer $id nomor anggota
    * @return Anggota model data anggota
    */
    protected function findModel($id)
    {
        if (($model = Anggota::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Halaman yang diminta tidak ditemukan.');
        }
    }

    /**
    * Membuat username dan password untuk data anggota baru.
    * @param integer $nomorAnggota nomor anggota
    * @param string $namaAnggota nama anggota
    * @return array kredensial berisi username dan password
    */
    private function createCredential($noAnggota,$namaAnggota)
    {
        $credential = array(
            'username' => "",
            'password' => "",
        );

        $nama = strtolower($namaAnggota);

        $splited_name = explode(" ",$nama);
        $textPart = "";

        //generate string dari nama untuk digabungkan dengan nomor anggota
        $counterTemp = 0;
        while(strlen($textPart) < 3){
            $textPart = $counterTemp > 0 ? $textPart.'.' : $textPart;
            $cleanedString = str_replace('.','',$splited_name[$counterTemp]);
            $textPart = $textPart.$cleanedString;
            $counter_temp = $counter_temp + 1;
        }

        //set password dengan gabungan nomor anggota dan string hasil generate
        $password = $nomorAnggota.$username;

        //set username dengan gabungan string hasil generate dan nomor anggota
        $username = $username.$nomorAnggota;

        //gabungkan username dan password ke dalam satu array
        $credential['username'] = $username;
        $credential['password'] = $password;
        return $credential;
    }
}

?>
