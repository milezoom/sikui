<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: ImageUpload.php
*/

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Kelas untuk model File Image.
 */
class ImageUpload extends Model
{
    /**
    * File Image yang diupload
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
            [['file'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
    * Label dari kolom attribut yang ditampilkan pada form HTML
    * @return array label kolom attribut
    */
    public function attributeLabels()
    {
        return [
            'file' => 'Upload Gambar',
        ];
    }

    /**
    * Menyimpan file image ke server.
    * @return boolean apakah berhasil menyimpan gambar
    */
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('images/barang/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
?>
