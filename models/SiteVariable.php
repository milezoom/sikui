<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: SiteVariable.php
*/

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * Kelas khusus untuk mengambil atau men-set data dari tabel site_variable.
 */
class SiteVariable
{
    /**
    * Menampilkan besar iuran simpanan pokok dari database.
    * @return integer besar iuran simpanan pokok
    */
    public static function getSimpananPokok()
    {
        $query = new Query();
        $simpananPokok = $query->select('value')->from('site_variable')
            ->where(['key'=>'Simpanan Pokok'])->createCommand()->queryOne();
        return intval($simpananPokok);
    }

    /**
    * Menampilkan besar iuran simpanan wajib dari database.
    * @return integer besar iuran simpanan wajib
    */
    public static function getSimpananWajib()
    {
        $query = new Query();
        $simpananWajib = $query->select('value')->from('site_variable')
            ->where(['key'=>'Simpanan Wajib'])->createCommand()->queryOne();
        return intval($simpananWajib);
    }

    /**
    * Menampilkan besar iuran dana sosial dari database.
    * @return integer besar iuran dana sosial
    */
    public static function getDanaSosial()
    {
        $query = new Query();
        $danaSosial = $query->select('value')->from('site_variable')
            ->where(['key'=>'Dana Sosial'])->createCommand()->queryOne();
        return intval($danaSosial);
    }

    /**
    * Menampilkan total besar dana sosial dari database.
    * @return integer total besar dana sosial
    */
    public static function getTotalDanaSosial()
    {
        $query = new Query();
        $totalDanaSosial = $query->select('value')->from('site_variable')
            ->where(['key'=>'Total Dana Sosial'])->createCommand()->queryOne();
        return intval($totalDanaSosial);
    }

    /**
    * Mengubah besar iuran simpanan pokok di database.
    * @param integer $value besar iuran simpanan pokok
    */
    public static function setSimpananPokok($value)
    {
        $query = new Query();
        $query->createCommand()->update(
            'site_variable',
            ['value' => intval($value)],
            ['key' => 'Simpanan Pokok'])
        ->execute();
    }

    /**
    * Mengubah besar iuran simpanan wajib di database.
    * @param integer $value besar iuran simpanan wajib
    */
    public static function setSimpananWajib($value)
    {
        $query = new Query();
        $query->createCommand()->update(
            'site_variable',
            ['value' => intval($value)],
            ['key' => 'Simpanan Wajib'])
        ->execute();
    }

    /**
    * Mengubah besar iuran dana sosial di database.
    * @param integer $value besar iuran dana sosial
    */
    public static function setDanaSosial($value)
    {
        $query = new Query();
        $query->createCommand()->update(
            'site_variable',
            ['value' => intval($value)],
            ['key' => 'Dana Sosial'])
        ->execute();
    }
}
?>
