<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: DanaSosial.php
*/

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Kelas untuk model data Dana Sosial.
 */
class DanaSosial extends ActiveRecord
{
    /**
    * Nama tabel di database.
    * @return string nama tabel
    */
    public static function tableName()
    {
        return 'dana_sosial';
    }

    /**
    * Rule validasi kolom di tabel
    * @return array rule validasi
    */
    public function rules()
    {
        return [
            [['tanggal','besar_pengeluaran'],'required'],
            [['id'],'integer'],
            [['tanggal'],'date','format'=>'php:Y-m-d'],
            [['besar_pengeluaran'],'integer'],
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
            'tanggal' => 'Tanggal',
            'besar_pengeluaran' => 'Besar Pengeluaran',
            'keterangan' => 'Keterangan',
        ];
    }
}

?>
