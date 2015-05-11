<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TransaksiSimpanan;

/**
 * TransaksiSimpananSearch represents the model behind the search form about `app\models\TransaksiSimpanan`.
 */
class TransaksiSimpananSearch extends TransaksiSimpanan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_trans', 'kode_simpanan', 'tanggal', 'no_anggota', 'keterangan'], 'safe'],
            [['jumlah'], 'integer'],
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
        $query = TransaksiSimpanan::find();

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
            'tanggal' => $this->tanggal,
            'jumlah' => $this->jumlah,
        ]);

        $query->andFilterWhere(['like', 'kode_trans', $this->kode_trans])
            ->andFilterWhere(['like', 'kode_simpanan', $this->kode_simpanan])
            ->andFilterWhere(['like', 'no_anggota', $this->no_anggota])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
