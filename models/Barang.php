<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: Barang.php
*/

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Kelas untuk model data Barang.
 */
class Barang extends ActiveRecord
{
    /**
    * Nama tabel di database.
    * @return string nama tabel
    */
    public static function tableName()
    {
        return 'barang';
    }

    /**
    * Rule validasi kolom di tabel
    * @return array rule validasi
    */
    public function rules()
    {
        return [
            [['nama','harga','banyak_tersedia','bisa_kredit'],'required'],
            [['id'],'integer'],
            [['nama'],'string'],
            [['harga'],'integer'],
            [['banyak_tersedia'],'integer'],
            [['bisa_kredit'],'string','max'=>5],
            [['img_file'],'string'],
        ];
    }

    /**
    * Label dari kolom attribut yang ditampilkan pada form HTML
    * @return array label kolom attribut
    */
    public function attributeLabels()
    {
        return [
            'id' => 'ID Barang',
            'nama' => 'Nama Barang',
            'harga' => 'Harga Barang',
            'banyak_tersedia' => 'Sisa Barang',
            'bisa_kredit' => 'Bisa Kredit',
            'img_file' => 'Nama File Gambar',
        ];
    }
}

?>
