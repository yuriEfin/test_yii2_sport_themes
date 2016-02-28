<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    /**
     * режим авторизации
     * actionIndex $this
     */
    const AUTH_MODE_LOGIN = 'auth';

    /**
     * Режим регистрации
     * actionIndex $this
     */
    const AUTH_MODE_REG = 'reg';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'cabinet'],
                'rules' => [
                    [
                        'actions' => ['logout', 'cabinet'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Старт appliaction - Формы регистрации и авторизации 
     * Обработка POST запросов на авторизацию / регистрацию
     * 
     */
    public function actionIndex()
    {
        $modelLogin = new \app\models\LoginForm();
        $modelSingUp = new \app\models\SingupForm();

        if (Yii::$app->request->isPost) {
            $mode = Yii::$app->request->post('mode');
            switch ($mode) {
                case self::AUTH_MODE_LOGIN:
                    if ($modelLogin->load(Yii::$app->request->post()) && $res = $this->login($modelLogin)) {
                        if ($res instanceof \yii\base\Model) {
                            $this->redirect(['cabinet']);
                        }
                    }
                    break;
                case self::AUTH_MODE_REG:
                    if ($modelSingUp->load(Yii::$app->request->post()) && $res = $this->signup($modelSingUp)) {
                        if ($res instanceof \yii\web\IdentityInterface) {
                            $modelSingUp->addError('username',
                                    'Пользователь не найден. Проверьте правильность вводимых Вами данных.');
                        } else {
                            $this->redirect(['index', 'reg' => 'ok']);
                        }
                    }
                    break;
            }
        }

        return $this->render('index',
                        [
                    'modelSingUp' => $modelSingUp,
                    'modelLogin' => $modelLogin,
        ]);
    }

    /**
     * Личный кабинет пользователя
     */
    public function actionCabinet()
    {
        $model = Yii::$app->user->identity;
        if (!$model) {
            $this->redirect(['index']);
        }
        // Изменение имени пользователя POST запрос
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->save(false);
        }

        return $this->render('cabinet', ['model' => $model]);
    }

    /**
     * Регистрация 
     */
    private function signup(\app\models\SingupForm $model)
    {
        $data = [];
        // данные пришли из диалога
        $is_dialog = Yii::$app->request->post('is_dialog', false);

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $model;
        }
    }

    /**
     * Авторизация 
     */
    private function login(\app\models\LoginForm $model)
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $model;
        }
    }

    /**
     * проверка токена после перехода по ссылке из письма на почту
     * var @key 
     */
    public function actionConfirm($key)
    {
        if (!Yii::$app->user->isGuest) {
            $this->redirect(['cabinet']);
        }

        $error = false;
        $model = \app\models\User::findOne(['email_confirm_token' => $key]);
        if ($model instanceof \yii\web\IdentityInterface) {
            switch ($model->status) {
                case \app\models\User::STATUS_ACTIVE:
                    $error = 'Данная ссылка устарела';
                    break;
                case \app\models\User::STATUS_WAIT:

                    $model->status = \app\models\User::STATUS_ACTIVE;

                    if ($model->save(false) && Yii::$app->user->login($model)) {
                        $this->redirect(['cabinet']);
                    }
                    break;
            }
        }

        return $this->render('confirm', ['error' => $error, 'model' => $model]);
    }

    /**
     * logout - exit account
     * @return type
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
