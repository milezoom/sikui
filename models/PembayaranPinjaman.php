<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembayaran_pinjaman".
 *
 * @property string $kode_trans
 * @property string $tgl_bayar
 * @property integer $no_angsuran
 * @property integer $jumlah
 *
 * @property TransaksiPinjaman $kodeTrans
 */
class PembayaranPinjaman extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pembayaran_pinjaman';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_trans', 'tgl_bayar', 'no_angsuran', 'jumlah'], 'required'],
            [['tgl_bayar'], 'safe'],
            [['kode_trans', 'no_angsuran', 'jumlah', 'jasa','denda'], 'integer'],
            ['jumlah','validateJumlah']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_trans' => 'Kode Transaksi Pinjaman',
            'tgl_bayar' => 'Tanggal Bayar Angsuran',
            'no_angsuran' => 'Angsuran Ke-',
            'jumlah' => 'Nominal Angsuran',
			'jasa' => 'Jasa',
			'denda' => 'Denda',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeTrans()
    {
        return $this->hasOne(TransaksiPinjaman::className(), ['kode_trans' => 'kode_trans']);
    }
    
    /**
     * Jumlah harus lebih besar dari 50000
     */
    public function validateJumlah($attribute)
    {
        if($this->$attribute < 50000){
            $this->addError($attribute,'Minimal jumlah 50000.');
        }
    }
}
