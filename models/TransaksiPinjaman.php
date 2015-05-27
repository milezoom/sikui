<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaksi_pinjaman".
 *
 * @property string $kode_trans
 * @property string $kode_pinjaman
 * @property string $no_anggota
 * @property integer $jumlah
 * @property integer $sisa_piutang
 * @property string $tgl_pinjam
 * @property string $jatuh_tempo
 * @property integer $banyak_angsuran
 * @property integer $denda
 * @property double $bunga
 * @property string $kode_barang
 * @property string $keterangan
 *
 * @property PembayaranPinjaman[] $pembayaranPinjamen
 * @property Barang $kodeBarang
 * @property JenisPinjaman $kodePinjaman
 * @property Anggota $noAnggota
 */
class TransaksiPinjaman extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaksi_pinjaman';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_pinjaman', 'no_anggota', 'jumlah', 'tgl_pinjam', 'banyak_angsuran'], 'required'],
            [['jumlah', 'banyak_angsuran'], 'integer'],
            [['tgl_pinjam', 'jatuh_tempo'], 'safe'],
            [['kode_pinjaman', 'kode_barang'], 'string', 'max' => 10],
            [['no_anggota'], 'string', 'max' => 20],
            ['jumlah','validateJumlah']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_trans' => 'Kode Transaksi',
            'kode_pinjaman' => 'Kode Pinjamanan',
            'no_anggota' => 'Nomor Anggota',
            'jumlah' => 'Jumlah Pinjaman',
            'sisa_piutang' => 'Sisa Piutang',
            'tgl_pinjam' => 'Tanggal Pinjaman',
            'jatuh_tempo' => 'Tanggal Jatuh Tempo',
            'banyak_angsuran' => 'Banyak Angsuran',
            'denda' => 'Denda',
            'kode_barang' => 'Kode Barang',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPembayaranPinjaman()
    {
        return $this->hasMany(PembayaranPinjaman::className(), ['kode_trans' => 'kode_trans']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeBarang()
    {
        return $this->hasOne(Barang::className(), ['kode' => 'kode_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnggota()
    {
        return $this->hasOne(Anggota::className(), ['no_anggota' => 'no_anggota']);
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
