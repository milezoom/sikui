<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anggota".
 *
 * @property string $no_anggota
 * @property string $nama
 * @property string $kode_unit
 * @property string $alamat
 * @property string $tgl_lahir
 * @property string $no_telepon
 * @property boolean $jenis_kelamin
 * @property integer $thn_pensiun
 * @property boolean $status
 * @property boolean $is_pns
 * @property string $no_ktp
 * @property string $tgl_masuk
 * @property integer $total_simpanan
 * @property integer $total_pinjaman
 * @property integer $total_simpanan_wajib
 * @property integer $total_simpanan_sukarela
 *
 * @property TransaksiSimpanan[] $transaksiSimpanans
 * @property Unit $kodeUnit
 * @property TransaksiPinjaman[] $transaksiPinjamen
 * @property User[] $users
 */
class Anggota extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'anggota';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_anggota', 'nama', 'kode_unit', 'alamat', 'tgl_lahir', 'jenis_kelamin', 'thn_pensiun', 'status', 'is_pns', 'tgl_masuk'], 'required'],
            [['tgl_lahir', 'tgl_masuk'], 'safe'],
            [['jenis_kelamin', 'status', 'is_pns'], 'boolean'],
            [['thn_pensiun', 'total_simpanan', 'total_pinjaman', 'total_simpanan_wajib', 'total_simpanan_sukarela'], 'integer'],
            [['no_anggota'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 30],
            [['kode_unit'], 'string', 'max' => 10],
            [['alamat'], 'string', 'max' => 150],
            [['no_telepon'], 'string', 'max' => 15],
            [['no_ktp'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_anggota' => 'No Anggota',
            'nama' => 'Nama',
            'kode_unit' => 'Kode Unit',
            'alamat' => 'Alamat',
            'tgl_lahir' => 'Tanggal Lahir',
            'no_telepon' => 'No Telepon',
            'jenis_kelamin' => 'Jenis Kelamin',
            'thn_pensiun' => 'Tahun Pensiun',
            'status' => 'Status Anggota',
            'is_pns' => 'Status Kepegawaian',
            'no_ktp' => 'No Ktp',
            'tgl_masuk' => 'Tanggal Masuk',
            'total_simpanan' => 'Total Simpanan',
            'total_pinjaman' => 'Total Pinjaman',
            'total_simpanan_wajib' => 'Total Simpanan Wajib',
            'total_simpanan_sukarela' => 'Total Simpanan Sukarela',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksiSimpanans()
    {
        return $this->hasMany(TransaksiSimpanan::className(), ['no_anggota' => 'no_anggota']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeUnit()
    {
        return $this->hasOne(Unit::className(), ['kode' => 'kode_unit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksiPinjamen()
    {
        return $this->hasMany(TransaksiPinjaman::className(), ['no_anggota' => 'no_anggota']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['no_anggota' => 'no_anggota']);
    }
}
