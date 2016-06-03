<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: Anggota.php
*/

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Kelas untuk model data Anggota.
 */
class Anggota extends ActiveRecord
{
    /**
    * Nama tabel di database.
    * @return string nama tabel
    */
    public static function tableName()
    {
        return 'anggota';
    }

    /**
    * Rule validasi kolom di tabel
    * @return array rule validasi
    */
    public function rules()
    {
        return [
            [['nama','tgl_masuk','kode_unit'],'required'],
            [['no_anggota'],'integer'],
            [['nama'],'string'],
            [['tgl_lahir'],'date','format'=>'php:Y-m-d'],
            [['tgl_masuk'],'date','format'=>'php:Y-m-d'],
            [['alamat'],'string'],
            [['kode_unit'],'integer'],
            [['telepon'],'string','max'=>20],
            [['jenis_kelamin'],'string','max'=>10],
            [['is_pns'],'string','max'=>5],
            [['thn_pensiun'],'integer'],
            [['no_ktp'],'string','max'=>16],
            [['total_simpanan'],'integer'],
            [['total_simpanan_pokok'],'integer'],
            [['total_simpanan_wajib'],'integer'],
            [['total_simpanan_sukarela'],'integer'],
            [['total_pinjaman'],'integer'],
            [['total_pinjaman_uang'],'integer'],
            [['total_kredit_barang'],'integer'],
            [['total_jasa'],'integer'],
            [['total_denda'],'integer'],
            [['total_dana_sosial'],'integer'],
            [['tgl_bayar_simpanan_terakhir'],'date','format'=>'php:Y-m-d'],
            [['pesan'],'string'],
            [['tgl_lahir'],'default','value'=>''],
        ];
    }

    /**
    * Label dari kolom attribut yang ditampilkan pada form HTML
    * @return array label kolom attribut
    */
    public function attributeLabels()
    {
        return [
            'no_anggota' => 'No Anggota',
            'nama' => 'Nama',
            'tgl_lahir' => 'Tanggal Lahir',
            'tgl_masuk' => 'Tanggal Masuk',
            'alamat' => 'Alamat',
            'kode_unit' => 'Kode Unit',
            'telepon' => 'Telepon',
            'jenis_kelamin' => 'Jenis Kelamin',
            'thn_pensiun' => 'Tahun Pensiun',
            'no_ktp' => 'No KTP',
            'total_simpanan' => 'Total Simpanan',
            'total_simpanan_pokok' => 'Total Simpanan Pokok',
            'total_simpanan_wajib' => 'Total Simpanan Wajib',
            'total_simpanan_sukarela' => 'Total Simpanan Sukarela',
            'total_pinjaman' => 'Total Pinjaman',
            'total_pinjaman_uang' => 'Total Pinjaman Uang',
            'total_kredit_barang' => 'Total Kredit Barang',
            'total_jasa' => 'Total Jasa',
            'total_denda' => 'Total Denda',
            'total_dana_sosial' => 'Total Dana Sosial',
            'tgl_bayar_simpanan_terakhir' => 'Terakhir Bayar Simpanan Wajib',
            'pesan' => 'Pesan',
        ];
    }

    /**
    * Mencari data user yang terkait dengan data anggota ini.
    * @return User data user
    */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['no_anggota' => 'no_anggota']);
    }

    /**
    * Mencari data unit kerja yang terkait dengan data anggota ini.
    * @return Unit data unit kerja
    */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['kode_unit' => 'kode_unit']);
    }
}

?>
