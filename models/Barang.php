<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barang".
 *
 * @property string $kode
 * @property string $nama
 * @property integer $harga
 * @property string $img_path
 *
 * @property TransaksiPinjaman[] $transaksiPinjamen
 */
class Barang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'barang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode', 'nama', 'harga'], 'required'],
            [['harga'], 'integer'],
            [['kode'], 'string', 'max' => 10],
            [['nama'], 'string', 'max' => 30],
            [['img_path'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'Kode',
            'nama' => 'Nama',
            'harga' => 'Harga',
            'img_path' => 'Img Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksiPinjamen()
    {
        return $this->hasMany(TransaksiPinjaman::className(), ['kode_barang' => 'kode']);
    }
}
