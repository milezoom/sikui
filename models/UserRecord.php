<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 */
class UserRecord extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'no_anggota','auth_key'], 'required'],
            [['username'], 'string', 'max' => 25],
            [['password'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['no_anggota'],'integer'],
            [['role'],'string','max' => 7]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'role' => 'Peran di Koperasi',
        ];
    }

    public function beforeSave($insert)
    {        
        $return = parent::beforeSave($insert);

        if($this->isAttributeChanged('password'))       
            $this->password = Yii::$app->security->generatePasswordHash($this->password);

        if($this->isNewRecord)
            $this->auth_key = Yii::$app->security->generateRandomString($length = 255);

        return $return;
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    public function validatePassword($password)
    {
        if ($this->isCorrectHash($password,$this->password)){
            return true;
        }
        return false;
    }
    
    private function isCorrectHash($plaintext, $hash)
    {
        return Yii::$app->security->validatePassword($plaintext,$hash);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('Maaf, login hanya bisa menggunakan username/password');
    }
}
