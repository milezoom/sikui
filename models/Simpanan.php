<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: Simpanan.php
*/

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Kelas untuk model data Transaksi Simpanan.
 */
class Simpanan extends ActiveRecord
{
    /**
    * Nama tabel di database.
    * @return string nama tabel
    */
    public static function tableName()
    {
        return 'transaksi_simpanan';
    }

    /**
    * Rule validasi kolom di tabel
    * @return array rule validasi
    */
    public function rules()
    {
        return [
            [[
                'no_anggota',
                'tanggal',
                'simpanan_wajib',
                'simpanan_sukarela',
                'dana_sosial',
                'shu',
            ],'required'],
            [['id'],'integer'],
            [['no_anggota'],'integer'],
            [['tanggal'],'date','format'=>'php:Y-m-d'],
            [['simpanan_wajib'],'integer'],
            [['simpanan_sukarela'],'integer'],
            [['dana_sosial'],'integer'],
            [['keterangan'],'string'],
        ];
    }

    /**
    * Label dari kolom attribut yang ditampilkan pada form HTML
    * @return array label kolom attribut
    */
    public function attributeLabels()
    {
        return [
            'id' => 'No Transaksi',
            'no_anggota' => 'No Anggota',
            'tanggal' => 'Tanggal Transaksi',
            'simpanan_wajib' => 'Simpanan Wajib',
            'simpanan_sukarela' => 'Simpanan Sukarela',
            'dana_sosial' => 'Dana Sosial',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
    * Mencari data anggota yang terkait dengan data transaksi simpanan ini.
    * @return Anggota data anggota
    */
    public function getAnggota()
    {
        return $this->hasOne(Anggota::className(), ['no_anggota' => 'no_anggota']);
    }
}

?>
