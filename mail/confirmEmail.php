<!DOCTYPE HTML>
<html>
    <head>
    </head>
    <body>
        <h3>КОРПОРАЦИЯ МОНСТРОВ !</h3>
        <a href="<?=
        Yii::$app->urlManager->createAbsoluteUrl(['/site/confirm',
            'key' => $token])
        ?>"> Для подтвержения аккаунта перейдите по ссылке </a>
    </body>
</html>