<?php

namespace app\models;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SingupForm extends Model
{

    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app',
                        'This email address has already been taken.')],
        ];
    }

    public function attributeLabels($key = null)
    {
        return [
            'email' => 'Email',
        ];
    }

    /**
     * Signs user up.
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $user = new User();
        if ($this->validate()) {
            $user->email = $this->email;
            $user->status = User::STATUS_WAIT;
            $user->generateEmailConfirmToken();

            if ($user->save(false)) {

                $send = Yii::$app->mailer->compose('confirmEmail',
                                ['token' => $user->email_confirm_token])
                        ->setFrom([Yii::$app->params['supportEmail']])
                        ->setTo($this->email)
                        ->setSubject('Email confirmation for ' . Yii::$app->name)
                        ->send();

                return $user;
            }
        } else {
            return $user->errors;
        }
    }

}
