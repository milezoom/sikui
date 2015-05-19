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
 * @property string $keterangan
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
            [['no_angsuran', 'jumlah'], 'integer'],
            [['kode_trans'], 'string', 'max' => 10]
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeTrans()
    {
        return $this->hasOne(TransaksiPinjaman::className(), ['kode_trans' => 'kode_trans']);
    }
}
