<?php

namespace app\models;

use Yii;
use yii\base\Model;

class GantiPassword extends Model
{
    public $passwordLama;
    public $passwordBaru;
    public $konfirmasiPassword;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['passwordLama', 'passwordBaru', 'konfirmasiPassword'], 'required'],
            [['passwordLama','passwordBaru','konfirmasiPassword'], 'string', 'max' => 5],
            [['passwordLama'],'cekPasswordLama'],
            [['konfirmasiPassword'],'validasiPassword']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'passwordLama' => 'Password Lama',
            'passwordBaru' => 'Password Baru',
            'konfirmasiPassword' => 'Konfirmasi Password Baru',
        ];
    }
    
    public function cekPasswordLama($attribute)
    {
        $currentUser = Yii::$app->user->identity;
        if(!$currentUser->validatePassword($this->$attribute)){
            $this->addError($attribute,'Password salah.');
        }
    }
    
    public function validasiPassword($attribute)
    {
        if($this->passwordBaru !== $this->$attribute){
            $this->addError($attribute,'Konfirmasi password salah.');
        }
    }
}
