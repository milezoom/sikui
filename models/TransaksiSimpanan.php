<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaksi_simpanan".
 *
 * @property string $kode_trans
 * @property string $kode_simpanan
 * @property string $tanggal
 * @property string $no_anggota
 * @property integer $jumlah
 * @property string $keterangan
 *
 * @property JenisSimpanan $kodeSimpanan
 * @property Anggota $noAnggota
 */
class TransaksiSimpanan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaksi_simpanan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_simpanan', 'tanggal', 'no_anggota', 'jumlah'], 'required'],
            [['tanggal', 'jatuh_tempo'], 'safe'],
            [['jumlah'], 'integer'],
            [['kode_trans', 'kode_simpanan'], 'string', 'max' => 10],
            [['no_anggota'], 'string', 'max' => 20],
            [['keterangan'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_trans' => 'Kode Transaksi',
            'kode_simpanan' => 'Jenis Simpanan',
            'tanggal' => 'Tanggal',
            'no_anggota' => 'No Anggota',
            'jumlah' => 'Jumlah',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeSimpanan()
    {
        return $this->hasOne(JenisSimpanan::className(), ['kode' => 'kode_simpanan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoAnggota()
    {
        return $this->hasOne(Anggota::className(), ['no_anggota' => 'no_anggota']);
    }
}
