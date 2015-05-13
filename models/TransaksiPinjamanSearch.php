<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TransaksiPinjaman;

/**
 * TransaksiPinjamanSearch represents the model behind the search form about `app\models\TransaksiPinjaman`.
 */
class TransaksiPinjamanSearch extends TransaksiPinjaman
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_trans', 'kode_pinjaman', 'no_anggota', 'tgl_pinjam', 'jatuh_tempo', 'kode_barang'], 'safe'],
            [['jumlah', 'sisa_piutang', 'banyak_angsuran', 'denda'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TransaksiPinjaman::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'jumlah' => $this->jumlah,
            'sisa_piutang' => $this->sisa_piutang,
            'tgl_pinjam' => $this->tgl_pinjam,
            'jatuh_tempo' => $this->jatuh_tempo,
            'banyak_angsuran' => $this->banyak_angsuran,
            'denda' => $this->denda,
        ]);

        $query->andFilterWhere(['like', 'kode_trans', $this->kode_trans])
            ->andFilterWhere(['like', 'kode_pinjaman', $this->kode_pinjaman])
            ->andFilterWhere(['like', 'no_anggota', $this->no_anggota])
            ->andFilterWhere(['like', 'kode_barang', $this->kode_barang]);

        return $dataProvider;
    }
}
