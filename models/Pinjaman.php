<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: Pinjaman.php
*/

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Kelas untuk model data Transaksi Pinjaman.
 */
class Pinjaman extends ActiveRecord
{
    /**
    * Nama tabel di database.
    * @return string nama tabel
    */
    public static function tableName()
    {
        return 'transaksi_pinjaman';
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
                'pinjaman_uang',
                'kredit_barang',
                'sisa_pinjaman',
                'banyak_angsuran',
                'sisa_angsuran',
            ],'required'],
            [['id'],'integer'],
            [['no_anggota'],'integer'],
            [['tanggal'],'date','format'=>'php:Y-m-d'],
            [['pinjaman_uang'],'integer'],
            [['kredit_barang'],'integer'],
            [['kode_barang'],'integer'],
            [['sisa_pinjaman'],'integer'],
            [['banyak_angsuran'],'integer'],
            [['sisa_angsuran'],'integer'],
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
            'pinjaman_uang' => 'Pinjaman Uang',
            'kredit_barang' => 'Kredit Barang',
            'kode_barang' => 'Kode Barang',
            'sisa_pinjaman' => 'Sisa Pinjaman',
            'banyak_angsuran' => 'Banyak Angsuran',
            'sisa_angsuran' => 'Sisa Angsuran',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
    * Mencari data barang yang terkait dengan data transaksi pinjaman ini.
    * @return Barang data barang
    */
    public function getBarang()
    {
        return $this->hasOne(Barang::className(), ['id' => 'kode_barang']);
    }
}

?>
