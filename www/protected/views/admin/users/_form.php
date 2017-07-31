<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>
<div class="row">

    <div class="span3 offset2">
    <?php if (Yii::app()->user->hasFlash('success')) { ?>

            <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success')); ?>

    <?php } ?>
    <?php if (Yii::app()->user->hasFlash('error')) { ?>

        <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_DANGER, Yii::app()->user->getFlash('error')); ?>

    <?php } ?>

</div>


    </div>
<div class="row">
<div class="span3 offset2">
    <i>Дата реєстрації: <?php echo date('d.m.Y', strtotime($model->date)) ?></i>
</div>
    <div class="span5 ">
        <i>Дата редагування: <?php echo date('d.m.Y', $model->update_date) ?></i><br/>
    </div>
</div>

<div class="row">
<?php $this->renderPartial('_menu',array('id'=>$model->id,'active'=> 'update'));?>

<div class="form span6">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'users-form',
        'htmlOptions' => array(
            'style' => 'display:inline-flex'
        ),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>
    <?php echo $form->errorSummary($model); ?>


    <?php if (Yii::app()->user->hasFlash('success_2')): ?>
        </br>
        <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success_2')); ?>
    <?php else: ?>
    <?php endif; ?>


    <div class="span3">

        <div class="row">
            <?php echo $form->labelEx($model, 'organisation'); ?>
            <?php echo $form->textField($model, 'organisation'); ?>
            <?php echo $form->error($model, 'organisation'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'organisation_status'); ?>
            <?php echo $form->dropDownList($model, 'organisation_status', array('ПП' => 'ПП', 'ТОВ' => 'ТОВ', 'ДП' => 'ДП')) ?>
            <?php echo $form->error($model, 'organisation_status'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array('size' => 30, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'phone'); ?>
            <?php echo $form->textField($model, 'phone'); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email', array('size' => 25, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'country'); ?>
            <?php echo $form->dropDownList($model, 'country', $countries) ?>
            <?php echo $form->error($model, 'country'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'region'); ?>
            <?php echo $form->dropDownList($model, 'region', $regions) ?>
            <?php echo $form->error($model, 'region'); ?>
        </div>


        <div class="row" id="city">
            <?php echo $form->labelEx($model, 'city'); ?>
            <?php echo $form->dropDownList($model, 'city', $cities, array('prompt' => '')) ?>
            <?php echo $form->error($model, 'city'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'carrier'); ?>
            <?php echo $form->dropDownList($model, 'carrier', array('Нова Пошта' => 'Нова Пошта', 'Гюнсел' => 'Гюнсел', 'Автолюкс' => 'Автолюкс', 'Інтайм' => 'Інтайм', 'Делівері' => 'Делівері', 'Самовивіз' => 'Самовивіз'), array('prompt' => '')) ?>
            <?php echo $form->error($model, 'carrier'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'district'); ?>
            <?php echo $form->textField($model, 'district'); ?>
            <?php echo $form->error($model, 'district'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'reg_like'); ?>
            <?php echo $form->dropDownList($model, 'reg_like', array('Магазин' => 'Магазин', 'Сервіс' => 'Сервіс', 'Перевізник' => 'Перевізник / власник ТЗ'), array('prompt' => '')) ?>
            <?php echo $form->error($model, 'reg_like'); ?>
        </div>
        <br/>

        <div class="row" style="background-color: #b0eeff">
            <a href="/admin/users/orders?id=<?php echo $model->id ?>">Останнє замовлення
                (<?php echo date('d.m.Y', time()) ?>): </a>
            <?php echo $lastOrder['price_out_sum'] ?>
        </div>
        <div class="row" style="background-color: #b0eeff">
            <a href="/admin/users/debit?id=<?php echo $model->id ?>">Останній платіж
                (<?php echo date('d.m.Y', strtotime($lastpayment['0']['date'])) ?>): </a>
            <?php echo $lastpayment['0']['summa'] ?>
        </div>
        <div class="row" style="background-color: #b0eeff">
            <a href="/admin/users/debit?id=<?php echo $model->id ?>">Заборгованість :</a>
            <?php echo $arrears ?>
        </div>


    </div>
    <div class="span3">



        <div class="row">
            <?php echo $form->labelEx($model, 'user_rol'); ?>
            <?php echo $form->dropDownList($model, 'user_rol', array(0 => "Не задано", 1 => "Продавець", 2 => 'Покупець'), array('options' => array(
                2 => array('class' => 'green'),
            ))); ?>
            <?php echo $form->error($model, 'user_rol'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'advance'); ?>
            <?php echo $form->dropDownList($model, 'advance', array( 1 => "Ввімкнути", 0 => "Вимкнути")); ?>
            <?php echo $form->error($model, 'advance'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'show_codes'); ?>
            <?php echo $form->dropDownList($model, 'show_codes', array(1 => "Так", 0 => "Ні")); ?>
            <?php echo $form->error($model, 'show_codes'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'opole'); ?>
            <?php echo $form->dropDownList($model, 'opole', array(0 => "Не задано", 1 => "Дрібний", 2 => "Середній", 3 => "Великий", 4 => "VIP")); ?>
            <?php echo $form->error($model, 'opole'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'role'); ?>
            <?php echo $form->dropDownList($model, 'role', array('user' => "Користувач", 'manager' => 'Менеджер', 'courier' => 'Куратор', 'administrator' => 'Адміністратор')); ?>
            <?php echo $form->error($model, 'role'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->dropDownList($model, 'status', array(0 => "Не підтверджений", 1 => "Підтверджений", 2 => 'Заблокований'), array('options' => array(
                1 => array('class' => 'green'),
                2 => array('class' => 'red'),
            ))); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'curator'); ?>
            <?php echo $form->dropDownList($model, 'curator', array(-1 => "", 1 => "Куратор 1", 2 => "Куратор 2", 3 => "Куратор 3", 4 => "Куратор 4", 5 => "Куратор 5")); ?>
            <?php echo $form->error($model, 'curator'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'martecs'); ?>
            <?php echo $form->dropDownList($model, 'martecs', $managers); ?>
            <?php echo $form->error($model, 'martecs'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'default_note'); ?>
            <?php echo $form->textArea($model, 'default_note', array('rows' => 50, 'style' => 'height:300px; !important')); ?>
            <?php echo $form->error($model, 'default_note'); ?>
        </div>




        <div class="btn-group">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Зберегти зміни' : 'Зберегти зміни', array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link('Видалити', '#', array('id' => 'delete', 'class' => 'btn btn-danger')) ?>
        </div>

    </div>
</div><!-- form -->

<?php $this->endWidget(); ?>
<div class="span4">
<br>

<h3>Діяльність на сайті</h3>


<div class="form-group">
        <?php
        $form = $this->beginWidget('CActiveForm') ?>

            Від<br/>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'from_date',
                'language' => 'uk',
                'value' => Yii::app()->request->getPost('from_date'),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            )); ?>

    <br/>
            &nbsp;До<br/>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'to_date',
                'language' => 'uk',
                'value' => Yii::app()->request->getPost('to_date'),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            )); ?>

<br>
            <?php echo TbHtml::submitButton('Ок', array('class' => 'btn btn-success')); ?>

        <?php $this->endWidget(); ?>
</div>

    <h5>Пробиті номери: <?php echo $count?></h5>
    <div style="overflow: auto; height: 550px">
        <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
            'id' => 'orders-grid',
            'fixedHeader' => true,
            'dataProvider' => $activity,
            'type' => 'bordered',
            'responsiveTable' => true,
            'template' => "{items}",
            'columns' => array(
                array(
//					'header' => '',
                    'value' => 'date("d.m.Y H:i", strtotime($data->date))',
                    'headerHtmlOptions' => array(
                        'style' => 'display:none'
                    )
                ),
                array(
//						'header' => '',
                    'value' => '$data->search',
                    'headerHtmlOptions' => array(
                        'style' => 'display:none'
                    )
                ),
                array(
//						'header' => '',
                    'type' => 'raw',
                    'value' => function ($data) {
                        if ($data->status == 1) {
                            return TbHtml::icon(TbHtml::ICON_OK);
                        }
                    },
                    'headerHtmlOptions' => array(
                        'style' => 'display:none'
                    ),
                    'htmlOptions' => array(
                        'style' => 'width:10px'
                    )
                ),

            ),
        )); ?>

    </div>
    <br/><br/><br/>
</div>
</div>
<script>
    $("#Users_region").change(function () {
        var region = $("#Users_region option:selected").val();
        $.ajax({
            type: "POST",
            url: "/site/city",
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
    $("#delete").click(function () {
        var password = prompt('Ви впевнені,що хочете видалити користувача? \n\n Для підтвердження введіть пароль. \n\n');
        if (password != null && password == '1234') {
            window.location.href = "/admin/users/deleteUser?id=" +<?php echo $model->id?>;
        } else {
            alert('Неправильний пароль.');
        }
    });
    $("#Users_curator").change(function () {
        var curator = $("#Users_curator option:selected").val();
        $.ajax({
            type: "POST",
            url: "/admin/users/getManagers",
            data: {
                curator_id: curator
            },
            success: function (data) {
                var managers = JSON.parse(data);
                $("#Users_martecs").empty();
                $.each(managers, function (value, key) {
                    $("#Users_martecs").append($("<option></option>", {
                            value: key['id'],
                            text: key['name']
                        })
                    )
                })
            }
        })
    })
</script>