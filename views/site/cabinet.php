<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="col-lg-4 head-auth"> Личный кабинет </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <?=
                        $this->renderAjax('_edit_form', ['model' => $model])
                        ?>
                    </div>
                    <!--<div class="col-lg-1 b-right"> </div>-->
                    <div class="col-lg-7">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>