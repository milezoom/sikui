<?php
/**
* Sistem Informasi Pegawai Rektorat UI
* version: 2016-03
* dibuat oleh: Tim Propensi C05 Propensi 2014/2015
* hak cipta: Koperasi Pegawai Rektorat UI
* filename: User.php
*/

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * Kelas untuk model data User.
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
    * Nama tabel di database.
    * @return string nama tabel
    */
    public static function tableName()
    {
        return 'users';
    }

    /**
    * Rule validasi kolom di tabel
    * @return array rule validasi
    */
    public function rules()
    {
        return [
            [['username','password','no_anggota','role'],'required'],
            [['id'],'integer'],
            [['username'],'string','max'=>20],
            [['password'],'string','max'=>255],
            [['no_anggota'],'integer'],
            [['role'],'string','max'=>7],
        ];
    }

    /**
    * Label dari kolom attribut yang ditampilkan pada form HTML
    * @return array label kolom attribut
    */
    public function attributeLabels()
    {
        return [
            'id' => 'ID User',
            'username' => 'Username',
            'password' => 'Password',
            'no_anggota' => 'No Anggota',
            'role' => 'Role',
        ];
    }

    /**
    * Konversi password ke dalam bentuk hash sebelum disimpan ke database.
    */
    public function beforeSave($insert)
    {
        $return = parent::beforeSave($insert);

        if($this->isAttributeChanged('password'))
        {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }

        return $return;
    }

    /**
    * Menampilkan id model User.
    * @return integer id user
    */
    public function getId()
    {
        return $this->id;
    }

    /**
    * Mencari data user berdasarkan id.
    * @param integer $id id dari user yang dicari
    * @return User data user
    */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
    * Mencari data user menggunakan access token.
    */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
    * Mencocokkan password yang dimasukkan dengan yang ada di database.
    * @param string $password teks password yang ingin divalidasi
    * @return boolean hasil pencocokan
    */
    public function validatePassword($password)
    {
        if ($this->isCorrectHash($password, $this->password))
        {
            return true;
        }

        return false;
    }

    /**
    * Membandingkan hash password di database dengan hash teks input.
    * @param string $plaintext teks yang ingin dibandingkan
    * @param string $hash teks password yang tersimpan di database
    * @return boolean hasil perbandingan
    */
    public function isCorrectHash($plaintext, $hash)
    {
        return Yii::$app->security->validatePassword($plaintext, $hash);
    }

    /**
    * Menampilkan authentication key dari user.
    */
    public function getAuthKey()
    {
        throw new NotSupportedException('"getAuthKey" is not implemented.');
    }

    /**
    * Validasi authentication key dari user.
    */
    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException('"validateAuthKey" is not implemented.');
    }

    /**
    * Mencari data user berdasarkan username.
    * @param string @username username dari user yang ingin dicari
    * @return User data user
    */
    public function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
}

?>
