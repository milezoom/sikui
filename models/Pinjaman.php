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
 * @property date $tgl_pinjam
 * @property date $jatuh_tempo
 * @property smallint $banyak_angsuran
 * @property integer $denda
 * @property float $bunga
 * @property string $kode_barang
 * @property string $keterangan
 *
 * @property JenisPinjaman $kodePinjaman
 * @property Barangn $kodeBarang
 * @property Anggota $noAnggota
 */
class Pinjaman extends \yii\db\ActiveRecord
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
            [['kode_trans', 'kode_pinjaman', 'no_anggota', 'jumlah', 'sisa_piutang', 'tgl_pinjam', 'jatuh_tempo', 'banyak_angsuran', 'denda', 'bunga'], 'required'],
            [['tgl_pinjam', 'jatuh_tempo'], 'safe'],
            [['jumlah', 'sisa_piutang', 'denda'], 'integer'],
            [['no_anggota'], 'string', 'max' => 20],
            [['kode_trans','kode_pinjaman','kode_barang'], 'string', 'max' => 10],
            [['banyak_angsuran'], 'smallint'],
            [['bunga'], 'float'],
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
            'kode_pinjaman' => 'Kode Pinjaman',
            'no_anggota' => 'Nomor Anggota',
            'jumlah' => 'Jumlah',
            'sisa_piutang' => 'Sisa Piutang',
            'tgl_pinjam' => 'Tanggal Pinjam',
            'jatuh_tempo' => 'Jatuh Tempo',
            'banyak_angsuran' => 'Banyak Angsuran',
            'denda' => 'Denda',
            'bunga' => 'Bunga',
            'kode_barang' => 'Kode Barang',
            'keterangan' => 'Keterangan'
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodePinjaman()
    {
        //return $this->hasOne(JenisPinjaman::className(), ['kode' => 'kode_pinjaman']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeBarang()
    {
        //return $this->hasOne(Barang::className(), ['kode' => 'kode_barang']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoAnggota()
    {
        //return $this->hasOne(Anggota::className(), ['no_anggota' => 'no_anggota']);
    }
}

?>