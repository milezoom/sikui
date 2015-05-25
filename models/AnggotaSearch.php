<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Anggota;

class AnggotaSearch extends Anggota
{
    public function rules()
    {
        return [
            [['no_anggota', 'nama', 'kode_unit', 'alamat', 'tgl_lahir', 'no_telepon', 'no_ktp', 'tgl_masuk'], 'safe'],
            [['jenis_kelamin', 'status', 'is_pns'], 'string'],
            [['thn_pensiun', 'total_simpanan', 'total_pinjaman'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Anggota::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_lahir' => $this->tgl_lahir,
            'thn_pensiun' => $this->thn_pensiun,
            'tgl_masuk' => $this->tgl_masuk,
            'total_simpanan' => $this->total_simpanan,
            'total_pinjaman' => $this->total_pinjaman,
        ]);

        $query->andFilterWhere(['like', 'no_anggota', $this->no_anggota])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'kode_unit', $this->kode_unit])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'no_telepon', $this->no_telepon])
            ->andFilterWhere(['like', 'no_ktp', $this->no_ktp])
            ->andFilterWhere(['like', 'jenis_kelamin', $this->jenis_kelamin])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'is_pns', $this->is_pns]);

        return $dataProvider;
    }
}
