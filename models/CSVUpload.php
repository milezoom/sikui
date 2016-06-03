<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: CSVUpload.php
*/

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Kelas untuk model File CSV.
 */
class CSVUpload extends Model
{
    /**
    * File CSV yang diupload
    * @var object
    */
    public $file;

    /**
    * Rule validasi kolom di tabel
    * @return array rule validasi
    */
    public function rules()
    {
        return [
            [['file'],'required'],
            [['file'],'file',
             'checkExtensionByMimeType' => false,
             'extensions' => 'csv',
            ],
        ];
    }

    /**
    * Label dari kolom attribut yang ditampilkan pada form HTML
    * @return array label kolom attribut
    */
    public function attributeLabels()
    {
        return [
            'file' => 'Upload CSV',
        ];
    }
}
?>
