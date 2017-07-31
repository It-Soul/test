<div class="span3">
    <?php $this->widget('ext.mywidgets.Admin.EditorMenu'); ?>
</div>
<div class="span9">
    <h4>Кінець робочого дня: <?php echo date('H:i', strtotime($time['date'])) ?></h4>
    <form action="/admin/editor/calendar">
        <?php $this->widget(
            'yiiwheels.widgets.timepicker.WhTimePicker',
            array(
                'name' => 'timepickertest',
                'pluginOptions' => array(
                    'showMeridian' => false,
                    'minuteStep' => 5
                ),
            )
        );
        echo CHtml::submitButton('Ок', array('class' => 'btn btn-primary ', 'style' => 'margin-top:-10px;'));
        ?>
    </form>
    <?php

    if (Yii::app()->user->hasFlash('сalendar')): ?>
        </br>
        <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('сalendar')); ?>
    <?php endif; ?>

    <?php


    $this->widget('ext.yiicalendar.YiiCalendar', array
    (
        'linksArray' => $items,

    )); ?>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"
         style="display: none">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <?php $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'messages-arrears-form',
                        // Please note: When you enable ajax validation, make sure the corresponding
                        // controller action is handling ajax validation correctly.
                        // See class documentation of CActiveForm for details on this,
                        // you need to use the performAjaxValidation()-method described there.
                        'enableAjaxValidation' => false,
                    )); ?>



                    <?php echo $form->errorSummary($model); ?>

                    <!--	<div class="row">-->
                    <!--		--><?php //echo $form->labelEx($model,'user_id'); ?>
                    <!--		--><?php //echo $form->textField($model,'user_id'); ?>
                    <!--		--><?php //echo $form->error($model,'user_id'); ?>
                    <!--	</div>-->
                    <div style="display: inline-flex; width: 100%">
                        <div style="width: 50%; border-right: 1px solid grey; margin-right: 15px">
                            <div class="row " style="margin: 0 !important;">

                                <?php echo $form->hiddenField($model, 'data'); ?>
                                <?php echo $form->error($model, 'data'); ?>
                            </div>
                            <table>
                                <tr>
                                    <td>
                                        <div class="row " style="margin: 0 !important;">
                                            <?php echo $form->labelEx($model, 'name'); ?>
                                            <?php echo $form->textField($model, 'name'); ?>
                                            <?php echo $form->error($model, 'name'); ?>
                                        </div>

                                        <div class="row" style="margin: 0 !important; border-bottom: 1px solid grey;">
                                            <?php echo $form->labelEx($model, 'sklep'); ?>
                                            <?php echo $form->dropDownList($model, 'sklep', array('' => '', 'centr' => 'Центральний офіс', 'filia' => 'Філія Ржешів')); ?>
                                            <?php echo $form->error($model, 'sklep'); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row " style="margin: 0 !important;">
                                            <?php echo $form->labelEx($model, 'name_1'); ?>
                                            <?php echo $form->textField($model, 'name_1'); ?>
                                            <?php echo $form->error($model, 'name_1'); ?>
                                        </div>

                                        <div class="row" style="margin: 0 !important; border-bottom: 1px solid grey;">
                                            <?php echo $form->labelEx($model, 'sklep_1'); ?>
                                            <?php echo $form->dropDownList($model, 'sklep_1', array('' => '', 'centr' => 'Центральний офіс', 'filia' => 'Філія Ржешів')); ?>
                                            <?php echo $form->error($model, 'sklep_1'); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row " style="margin: 0 !important;">
                                            <?php echo $form->labelEx($model, 'name_2'); ?>
                                            <?php echo $form->textField($model, 'name_2'); ?>
                                            <?php echo $form->error($model, 'name_2'); ?>
                                        </div>

                                        <div class="row" style="margin: 0 !important; border-bottom: 1px solid grey;">
                                            <?php echo $form->labelEx($model, 'sklep_2'); ?>
                                            <?php echo $form->dropDownList($model, 'sklep_2', array('' => '', 'centr' => 'Центральний офіс', 'filia' => 'Філія Ржешів')); ?>
                                            <?php echo $form->error($model, 'sklep_2'); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row " style="margin: 0 !important;">
                                            <?php echo $form->labelEx($model, 'name_3'); ?>
                                            <?php echo $form->textField($model, 'name_3'); ?>
                                            <?php echo $form->error($model, 'name_3'); ?>
                                        </div>

                                        <div class="row" style="margin: 0 !important; border-bottom: 1px solid grey;">
                                            <?php echo $form->labelEx($model, 'sklep_3'); ?>
                                            <?php echo $form->dropDownList($model, 'sklep_3', array('' => '', 'centr' => 'Центральний офіс', 'filia' => 'Філія Ржешів')); ?>
                                            <?php echo $form->error($model, 'sklep_3'); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row " style="margin: 0 !important;">
                                            <?php echo $form->labelEx($model, 'name_4'); ?>
                                            <?php echo $form->textField($model, 'name_4'); ?>
                                            <?php echo $form->error($model, 'name_4'); ?>
                                        </div>

                                        <div class="row" style="margin: 0 !important; border-bottom: 1px solid grey;">
                                            <?php echo $form->labelEx($model, 'sklep_4'); ?>
                                            <?php echo $form->dropDownList($model, 'sklep_4', array('' => '', 'centr' => 'Центральний офіс', 'filia' => 'Філія Ржешів')); ?>
                                            <?php echo $form->error($model, 'sklep_4'); ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="width: 50%; margin-right: 15px">
                            <table>
                                <tr>
                                    <td>
                                        <div class="row " style="margin: 0 !important;">
                                            <?php echo $form->labelEx($model, 'name_5'); ?>
                                            <?php echo $form->textField($model, 'name_5'); ?>
                                            <?php echo $form->error($model, 'name_5'); ?>
                                        </div>

                                        <div class="row" style="margin: 0 !important; border-bottom: 1px solid grey;">
                                            <?php echo $form->labelEx($model, 'sklep_5'); ?>
                                            <?php echo $form->dropDownList($model, 'sklep_5', array('' => '', 'centr' => 'Центральний офіс', 'filia' => 'Філія Ржешів')); ?>
                                            <?php echo $form->error($model, 'sklep_5'); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row " style="margin: 0 !important;">
                                            <?php echo $form->labelEx($model, 'name_6'); ?>
                                            <?php echo $form->textField($model, 'name_6'); ?>
                                            <?php echo $form->error($model, 'name_6'); ?>
                                        </div>

                                        <div class="row" style="margin: 0 !important; border-bottom: 1px solid grey;">
                                            <?php echo $form->labelEx($model, 'sklep_6'); ?>
                                            <?php echo $form->dropDownList($model, 'sklep_6', array('' => '', 'centr' => 'Центральний офіс', 'filia' => 'Філія Ржешів')); ?>
                                            <?php echo $form->error($model, 'sklep_6'); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row " style="margin: 0 !important;">
                                            <?php echo $form->labelEx($model, 'name_7'); ?>
                                            <?php echo $form->textField($model, 'name_7'); ?>
                                            <?php echo $form->error($model, 'name_7'); ?>
                                        </div>

                                        <div class="row" style="margin: 0 !important; border-bottom: 1px solid grey;">
                                            <?php echo $form->labelEx($model, 'sklep_7'); ?>
                                            <?php echo $form->dropDownList($model, 'sklep_7', array('' => '', 'centr' => 'Центральний офіс', 'filia' => 'Філія Ржешів')); ?>
                                            <?php echo $form->error($model, 'sklep_7'); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row " style="margin: 0 !important;">
                                            <?php echo $form->labelEx($model, 'name_8'); ?>
                                            <?php echo $form->textField($model, 'name_8'); ?>
                                            <?php echo $form->error($model, 'name_8'); ?>
                                        </div>

                                        <div class="row" style="margin: 0 !important; border-bottom: 1px solid grey;">
                                            <?php echo $form->labelEx($model, 'sklep_8'); ?>
                                            <?php echo $form->dropDownList($model, 'sklep_8', array('' => '', 'centr' => 'Центральний офіс', 'filia' => 'Філія Ржешів')); ?>
                                            <?php echo $form->error($model, 'sklep_8'); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row " style="margin: 0 !important;">
                                            <?php echo $form->labelEx($model, 'name_9'); ?>
                                            <?php echo $form->textField($model, 'name_9'); ?>
                                            <?php echo $form->error($model, 'name_9'); ?>
                                        </div>

                                        <div class="row" style="margin: 0 !important; border-bottom: 1px solid grey;">
                                            <?php echo $form->labelEx($model, 'sklep_9'); ?>
                                            <?php echo $form->dropDownList($model, 'sklep_9', array('' => '', 'centr' => 'Центральний офіс', 'filia' => 'Філія Ржешів')); ?>
                                            <?php echo $form->error($model, 'sklep_9'); ?>
                                        </div>
                                    </td>
                                </tr>


                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <?php echo CHtml::submitButton('Зберегти', array('class' => 'btn btn-primary')); ?>


                    <?php $this->endWidget(); ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>

                </div>
            </div>
        </div>
    </div>
</div>
<!--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>-->
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<?php if (Yii::app()->session['reload'] == 1) { ?>
    <script>
        window.location.href = '/admin/editor/calendar';
    </script>
<?php };
Yii::app()->session['reload'] = 0 ?>
<script type="text/javascript">
    $("#activedate").live("click",
        function () {
            $(".modal-header").html($(this).attr('data-date'));
            $("#Calendar_data").val($(this).attr('data-date'));
            $("#Calendar_name").val('');
            $("#Calendar_sklep").val('');
            $("#Calendar_name_1").val('');
            $("#Calendar_sklep_1").val('');
            $("#Calendar_name_2").val('');
            $("#Calendar_sklep_2").val('');
            $("#Calendar_name_3").val('');
            $("#Calendar_sklep_3").val('');
            $("#Calendar_name_4").val('');
            $("#Calendar_sklep_4").val('');
            $("#Calendar_name_5").val('');
            $("#Calendar_sklep_5").val('');
            $("#Calendar_name_6").val('');
            $("#Calendar_sklep_6").val('');
            $("#Calendar_name_7").val('');
            $("#Calendar_sklep_7").val('');
            $("#Calendar_name_8").val('');
            $("#Calendar_sklep_8").val('');
            $("#Calendar_name_9").val('');
            $("#Calendar_sklep_9").val('');
            $.ajax({
                type: "POST",
                url: '/admin/editor/worked',
//                async : false,
                data: {date: $(this).attr('data-date')},
                success: function (info) {
                    var data = JSON.parse(info);
                    $("#Calendar_name").val(data['name']);
                    $("#Calendar_sklep").val(data['sklep']);
                    $("#Calendar_name_1").val(data['name_1']);
                    $("#Calendar_sklep_1").val(data['sklep_1']);
                    $("#Calendar_name_2").val(data['name_2']);
                    $("#Calendar_sklep_2").val(data['sklep_2']);
                    $("#Calendar_name_3").val(data['name_3']);
                    $("#Calendar_sklep_3").val(data['sklep_3']);
                    $("#Calendar_name_4").val(data['name_4']);
                    $("#Calendar_sklep_4").val(data['sklep_4']);
                    $("#Calendar_name_5").val(data['name_5']);
                    $("#Calendar_sklep_5").val(data['sklep_5']);
                    $("#Calendar_name_6").val(data['name_6']);
                    $("#Calendar_sklep_6").val(data['sklep_6']);
                    $("#Calendar_name_7").val(data['name_7']);
                    $("#Calendar_sklep_7").val(data['sklep_7']);
                    $("#Calendar_name_8").val(data['name_8']);
                    $("#Calendar_sklep_8").val(data['sklep_8']);
                    $("#Calendar_name_9").val(data['name_9']);
                    $("#Calendar_sklep_9").val(data['sklep_9']);
                }
            })

        }
    )


</script>


