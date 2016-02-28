<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-5 control-label pull-left'],
                ],
    ]);
    ?>

    <div class="form-group">
        <div class="row">
            <?= \yii\helpers\Html::hiddenInput('mode', 'auth'); ?>
            <?=
            $form->field($model, 'email')->textInput(['autofocus' => true,
                'class' => 'form-control', 'placeholder' => 'Электронная почта'])->label(false);
            ?>
            <?=
            $form->field($model, 'password')->passwordInput([
                'class' => 'form-control', 'placeholder' => 'Ваш пароль'])->label(false);
            ?>
        </div>
        <div class="row">
            <?=
            Html::submitButton(Yii::t('app', 'Sing Up'),
                    ['class' => 'btn btn-primary col-lg-12',
                'name' => 'reg-button'])
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>