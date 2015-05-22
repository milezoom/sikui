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
	public $anggota;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_trans', 'kode_pinjaman', 'no_anggota', 'tgl_pinjam', 'kode_barang', 'anggota'], 'safe'],
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
		$query->joinWith(['anggota']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
		
		$dataProvider->sort->attributes['anggota'] = [
			'asc' => ['anggota.no_anggota' => SORT_ASC],
			'desc' => ['anggota.no_anggota' => SORT_DESC]
		];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'jumlah' => $this->jumlah,
            'sisa_piutang' => $this->sisa_piutang,
            'tgl_pinjam' => $this->tgl_pinjam,
            'banyak_angsuran' => $this->banyak_angsuran,
            'denda' => $this->denda,
        ]);

        $query->andFilterWhere(['like', 'kode_trans', $this->kode_trans])
            ->andFilterWhere(['like', 'kode_pinjaman', $this->kode_pinjaman])
            ->andFilterWhere(['like', 'no_anggota', $this->no_anggota])
            ->andFilterWhere(['like', 'kode_barang', $this->kode_barang])
			->andFilterWhere(['like', 'anggota.nama', $this->anggota]);

        return $dataProvider;
    }
}
