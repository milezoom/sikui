<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: PembayaranPinjaman.php
*/

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Kelas untuk model data Pembayaran Pinjaman.
 */
class PembayaranPinjaman extends ActiveRecord
{
    /**
    * Nama tabel di database.
    * @return string nama tabel
    */
    public static function tableName()
    {
        return 'pembayaran_pinjaman';
    }

    /**
    * Rule validasi kolom di tabel
    * @return array rule validasi
    */
    public function rules()
    {
        return [
            [[
                'id_pinjaman',
                'tanggal',
                'besar_pembayaran_pokok',
                'besar_pembayaran_jasa',
                'besar_pembayaran_denda'
            ],'required'],
            [['id'],'integer'],
            [['id_pinjaman'],'integer'],
            [['tanggal'],'date','format'=>'php:Y-m-d'],
            [['besar_pembayaran_pokok'],'integer'],
            [['besar_pembayaran_jasa'],'integer'],
            [['besar_pembayaran_denda'],'integer'],
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
            'id_pinjaman' => 'No Pinjaman',
            'tanggal' => 'Tanggal Transaksi',
            'besar_pembayaran_pokok' => 'Besar Pokok',
            'besar_pembayaran_jasa' => 'Besar Jasa',
            'besar_pembayaran_denda' => 'Besar Denda',
            'keterangan' => 'Keterangan',
        ];
    }


    /**
    * Mencari data pinjaman yang terkait dengan data pembayaran ini.
    * @return Pinjaman data pinjaman
    */
    public function getPinjaman()
    {
        return $this->hasOne(Pinjaman::className(), ['id' => 'id_pinjaman']);
    }
}

?>
