<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Anggota;

/**
 * AnggotaSearch represents the model behind the search form about `app\models\Anggota`.
 */
class AnggotaSearch extends Anggota
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_anggota', 'nama', 'kode_unit', 'alamat', 'tgl_lahir', 'no_telepon', 'no_ktp', 'tgl_masuk'], 'safe'],
            [['jenis_kelamin', 'status', 'is_pns'], 'boolean'],
            [['thn_pensiun', 'total_simpanan', 'total_pinjaman'], 'integer'],
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
        $query = Anggota::find();

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
            'tgl_lahir' => $this->tgl_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'thn_pensiun' => $this->thn_pensiun,
            'status' => $this->status,
            'is_pns' => $this->is_pns,
            'tgl_masuk' => $this->tgl_masuk,
            'total_simpanan' => $this->total_simpanan,
            'total_pinjaman' => $this->total_pinjaman,
        ]);

        $query->andFilterWhere(['like', 'no_anggota', $this->no_anggota])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'kode_unit', $this->kode_unit])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'no_telepon', $this->no_telepon])
            ->andFilterWhere(['like', 'no_ktp', $this->no_ktp]);

        return $dataProvider;
    }
}
