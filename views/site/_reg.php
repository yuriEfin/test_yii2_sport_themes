<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'reg-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-5 control-label pull-left'],
                ],
    ]);
    ?>
    <div class="row">
        <?= \yii\helpers\Html::hiddenInput('mode', 'reg'); ?>

        <?=
        $form->field($model, 'email')->textInput(['autofocus' => true,
            'class' => 'form-control', 'placeholder' => 'Email'])->label(false)
        ?>

        <?=
        Html::submitButton(Yii::t('app', 'Log In'),
                ['class' => 'btn btn-primary col-lg-12',
            'name' => 'login-button'])
        ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>