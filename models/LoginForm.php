<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{

    public $email;
    public $password;

    /**
     * add user cookie 
     * @var boolean
     */
    public $rememberMe = true;

    /**
     * app\models\User
     * @var mixed object || null
     */
    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->_user && $this->validate()) {
            return Yii::$app->user->login($this->_user,
                            $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    private function getUser()
    {
        if (FALSE !== \preg_match('/@/', $this->email)) {
            $this->_user = User::findByEmail($this->email);
        } else {
            $this->_user = User::findByUsername($this->email);
        }

        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Email or Username'),
        ];
    }

}
