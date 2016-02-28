<?php

namespace app\models;

use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * пользователь авктивен
     */
    const STATUS_ACTIVE = 1;

    /**
     * email пользователя ожидает подтверждения  
     */
    const STATUS_WAIT = 2;

    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'lastname'], 'required'],
            [['username', 'lastname'], 'match', 'pattern' => '#^/[a-zA-Z0-9-_.]+$/#i'],
            ['username', 'unique', 'targetClass' => self::className(), 'message' => 'This username has already been taken.'],
            ['login', 'unique', 'targetClass' => self::className(), 'message' => 'This login has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['password_hash', 'is_send_mail', 'is_dialog', 'is_generate_data', 'created_at',
            'updated_at'], 'safe'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => 'This email address has already been taken.'],
            ['email', 'string', 'max' => 255],
            [['status', 'is_save_pers'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],
        ];
    }

    /**
     * statuses
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_WAIT,
        ];
    }

    public function beforeSave($insert)
    {
        // if new record
        if ($insert) {
            $this->created_at = $this->updated_at = date("Y-m-d h:i:s");
        } else {
            $this->updated_at = date("Y-m-d h:i:s");
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     * Получаем по primary key
     */
    public static function findIdentity($id)
    {
        return static::find()->where(['id' => $id, 'status' => self::STATUS_ACTIVE])->one();
    }

    /**
     * @inheritdoc
     * Получаем юзера по токену
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['touken' => ':t'], [':t' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => ':uname'], [':uname' => $username]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => ':email'], [':email' => $email]);
    }

    /**
     * Generates email confirmation token
     */
    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

}
