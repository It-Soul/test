<div class="span12">
    <h4>Реєстрація користувача</h4>
    <?php
    if (Yii::app()->user->hasFlash('registration')): ?>
        </br>
        <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('registration')); ?>
    <?php else: ?>
    <?php endif; ?>


    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'users-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        )); ?>
        <?php echo $form->errorSummary($model); ?>
        <p class="note">Поля зі значком <span class="required">*</span> обов’язкові.</p>

        <div class="row" style="margin-left: 0">
            <?php echo $form->labelEx($model, 'organisation'); ?>
            <?php echo $form->textField($model, 'organisation'); ?>
            <?php echo $form->error($model, 'organisation'); ?>
        </div>

        <div class="row" style="margin-left: 0">
            <?php echo $form->labelEx($model, 'organisation_status'); ?>
            <?php echo $form->dropDownList($model, 'organisation_status', array('ПП' => 'ПП', 'ТОВ' => 'ТОВ', 'ДП' => 'ДП', 'ТДВ' => 'ТДВ', 'ТзОВ' => 'ТзОВ', 'ФОП' => 'ФОП')) ?>
            <?php echo $form->error($model, 'organisation_status'); ?>
        </div>

        <div class="row" style="margin-left: 0">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username'); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>

        <div class="row" style="margin-left: 0">
            <?php echo $form->labelEx($model, 'phone'); ?>
            <?php echo $form->textField($model, 'phone'); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>

        <div class="row" style="margin-left: 0">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email'); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>

        <div class="row" id="country" style="margin-left: 0">
            <?php echo $form->labelEx($model, 'country'); ?>
            <?php echo $form->dropDownList($model, 'country', $countries, array('prompt' => '')) ?>
            <?php echo $form->error($model, 'country'); ?>
        </div>
        <div class="row" id="region" style="display: none; margin-left: 0">
            <?php echo $form->labelEx($model, 'region'); ?>
            <?php echo $form->dropDownList($model, 'region', array(), array('prompt' => '')) ?>
            <?php echo $form->error($model, 'region'); ?>
        </div>

        <div class="row" id="city" style="display: none; margin-left: 0">
            <?php echo $form->labelEx($model, 'city'); ?>
            <?php echo $form->dropDownList($model, 'city', array(), array('prompt' => '')) ?>
            <?php echo $form->error($model, 'city'); ?>
        </div>

        <div class="row" style="margin-left: 0">
            <?php echo $form->labelEx($model, 'reg_like'); ?>
            <?php echo $form->dropDownList($model, 'reg_like', array('Магазин' => 'Магазин', 'Сервіс' => 'Сервіс', 'Перевізник' => 'Перевізник / власник ТЗ'), array('prompt' => '')) ?>
            <?php echo $form->error($model, 'reg_like'); ?>
        </div>

        <div class="row" style="margin-left: 0">
            <?php echo $form->labelEx($model, 'carrier'); ?>
            <?php echo $form->dropDownList($model, 'carrier', array('Нова Пошта' => 'Нова Пошта', 'Гюнсел' => 'Гюнсел', 'Автолюкс' => 'Автолюкс', 'Інтайм' => 'Інтайм', 'Делівері' => 'Делівері', 'Самовивіз' => 'Самовивіз'), array('prompt' => '')) ?>
            <?php echo $form->error($model, 'carrier'); ?>
        </div>

        <div class="row" style="margin-left: 0">
            <?php echo $form->labelEx($model, 'district'); ?>
            <?php echo $form->textField($model, 'district'); ?>
            <?php echo $form->error($model, 'district'); ?>
        </div>

        <div class="row" style="margin-left: 0">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password'); ?>
            <?php echo $form->error($model, 'password'); ?>


        </div>
        <div class="row" style="margin-left: 0">
            <?php echo $form->labelEx($model, 'password_2'); ?>
            <?php echo $form->passwordField($model, 'password_2'); ?>
            <?php echo $form->error($model, 'password_2'); ?>
        </div>


        <div class="row buttons">
            <?php echo CHtml::submitButton('Зареєструвати', array('class' => 'btn btn-success', 'id' => 'register', 'style' => 'margin-left: 30px')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
</div>
<script type="text/javascript" src="/js/maskedinput.js"></script>
<script>
    $("#Users_country").change(function () {
        var country = $("#Users_country option:selected").val();
        $.ajax({
            type: "POST",
            url: "/admin/users/region",
            data: {
                country_id: country
            },
            success: function (json) {
                var data = JSON.parse(json);
                $("#Users_region").empty();
                $("#Users_region").append($("<option></option>", {
                    value: '',
                    text: ''
                }));
                $("#region").fadeIn(200);
                for (var dataVal in data) {
                    $("#Users_region").append($("<option></option>", {
                        value: dataVal,
                        text: data[dataVal]
                    }));
                }
                ;
            }
        });
    });

    $("#Users_region").change(function () {
        var region = $("#Users_region option:selected").val();
        $.ajax({
            type: "POST",
            url: "/admin/users/city",
            data: {
                region_id: region
            },
            success: function (json) {
                var data = JSON.parse(json);
                $("#Users_city").empty();
                $("#Users_city").append($("<option></option>", {
                    value: '',
                    text: ''
                }));
                $("#city").fadeIn(200);
                for (var dataVal in data) {
                    $("#Users_city").append($("<option></option>", {
                        value: dataVal,
                        text: data[dataVal]
                    }));
                }
                ;
            }
        });
    });
    $("#Users_phone").mask('+38(999) 999 99 99');
    //    $("#Users_phone").change(function(){
    //        if($(this).val() != ''){
    //            $("#sendConfirmCode").attr('disabled', false);
    //        } else {
    //            $("#sendConfirmCode").attr('disabled', true);
    //        }
    //    });
    //    $("#sendConfirmCode").click(function(){
    //        $.ajax({
    //            type : "POST",
    //            url : '/site/confirm',
    //            data : {
    //                phone : $("#Users_phone").val()
    //            },
    //            success : function(json){
    //                var confirm_result = JSON.parse(json);
    ////                alert(confirm_result['code']);
    //                if(confirm_result['status']==1){
    //                    $("#confirmDiv").fadeIn();
    //                }
    //            }
    //        });
    //    });
    //    $("#checkConfirmCode").click(function(){
    //        $.ajax({
    //            type : "POST",
    //            url : '/site/check',
    //            data : {
    //                code : $("#confirmCode").val()
    //            },
    //            success : function(json){
    //                var data = JSON.parse(json);
    //                if(data['status']==1){
    //                    $("#register").attr('disabled', false);
    //                } else {
    //                    $("#register").attr('disabled', true);
    //                }
    //            }
    //        })
    //    })
</script>