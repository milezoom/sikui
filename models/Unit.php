<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: Unit.php
*/

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Kelas untuk model data Unit Kerja.
 */
class Unit extends ActiveRecord
{
    /**
    * Nama tabel di database.
    * @return string nama tabel
    */
    public static function tableName()
    {
        return 'unit_kerja';
    }

    /**
    * Rule validasi kolom di tabel
    * @return array rule validasi
    */
    public function rules()
    {
        return [
            [['nama_unit'],'required'],
            [['kode_unit'],'integer'],
            [['nama_unit'],'string'],
        ];
    }

    /**
    * Label dari kolom attribut yang ditampilkan pada form HTML
    * @return array label kolom attribut
    */
    public function attributeLabels()
    {
        return [
            'kode_unit' => 'Kode Unit',
            'nama_unit' => 'Nama Unit',
        ];
    }
}

?>
