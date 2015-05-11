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
            [['kode_trans', 'tgl_bayar', 'no_angsuran', 'jumlah', 'keterangan'], 'required'],
            [['tgl_bayar'], 'safe'],
            [['no_angsuran', 'jumlah'], 'integer'],
            [['kode_trans'], 'string', 'max' => 10],
            [['keterangan'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_trans' => 'Kode Trans',
            'tgl_bayar' => 'Tgl Bayar',
            'no_angsuran' => 'No Angsuran',
            'jumlah' => 'Jumlah',
            'keterangan' => 'Keterangan',
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
