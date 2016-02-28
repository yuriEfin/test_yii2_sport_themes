<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'edit-form',
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
            $form->field($model, 'username')->textInput([
                'class' => 'form-control', 'placeholder' => 'Ваше имя']);
            ?>

        </div>
        <div class="row">
            <?=
            Html::submitButton(Yii::t('app', 'Save'),
                    ['class' => 'btn btn-primary col-lg-12',
                'name' => 'edit-button'])
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>