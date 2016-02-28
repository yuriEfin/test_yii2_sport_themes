.<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */



$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <h3 class="col-lg-5 head-reg"> Регистрация</h3>
                    <h3 class="col-lg-4 head-auth"> Авторизация</h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-lg-5">
                    <?=$this->renderAjax('_login')?>
                </div>
                <div class="col-lg-1 b-right"> </div>
                <div class="col-lg-5">
                   <?=$this->renderAjax('_reg')?>
                </div>
            </div>
        </div>
    </div>
</div>
