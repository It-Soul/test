<?php $this->renderPartial('_menu',array('id'=>$user_id,'active'=> 'declarations'));?>
<div class="span10">
    <?php echo TbHtml::well(Users::model()->getUserName($user_id), array('size' => TbHtml::WELL_SIZE_SMALL, 'style' => 'width:100%')); ?>
    <h3>Декларації / відправки</h3>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'declarations-form',

    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <?php if(Yii::app()->user->hasFlash('success')): ?>
</br>
    <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success')); ?>


<?php else: ?>
<?php endif; ?>

<?php echo $form->errorSummary($model); ?>

<!--<div class="row">-->
<!--    --><?php //echo $form->labelEx($model,'user_id'); ?>
<!--    --><?php //echo $form->textField($model,'user_id'); ?>
<!--    --><?php //echo $form->error($model,'user_id'); ?>
<!--</div>-->

<div class="row span3">
    <?php echo $form->labelEx($model,'date'); ?>
    <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
        'name'=>'date',
        'language' =>'uk',

        'htmlOptions'=>array(
            'style'=>'height:20px;'
        ),
    ));?>
    <?php echo $form->error($model,'date'); ?>
</div>

<div class="row span3">
    <?php echo $form->labelEx($model,'places_numb'); ?>
    <?php echo $form->textField($model,'places_numb',array('size'=>20,'maxlength'=>20)); ?>
    <?php echo $form->error($model,'places_numb'); ?>
</div>

    <?php echo $form->hiddenField($model,'user_id',array('value'=>$user_id)); ?>


<!--<div class="row">-->
<!--    --><?php //echo $form->labelEx($model,'places_numb'); ?>
<!--    --><?php //echo $form->textField($model,'places_numb'); ?>
<!--    --><?php //echo $form->error($model,'places_numb'); ?>
<!--</div>-->

<div class="row ">
    <?php echo $form->labelEx($model,'courier'); ?>
    <?php echo $form->dropDownList($model,'courier',  array('Нова Пошта' => 'Нова Пошта', 'Гюнсел' => 'Гюнсел', 'Автолюкс' => 'Автолюкс','Інтайм' => 'Інтайм', 'Делівері' => 'Делівері'), array('prompt'=>''))?>
    <?php echo $form->error($model,'courier'); ?>


</div>
    <div class="row span6">
        <?php echo $form->labelEx($model,'declar_numb'); ?>
        <?php echo $form->textField($model,'declar_numb');?>
        <?php echo $form->error($model,'declar_numb'); ?>
    </div>

<div class="row span8">
    <?php echo $form->labelEx($model,'comment'); ?>
    <?php echo $form->textArea($model,'comment',array('rows'=>3,'style'=>'width:508px;!important')); ?>
    <?php echo $form->error($model,'comment'); ?>


</div>
<br>
<div class="row buttons span1 " style="margin-top:15px;margin-left:-170px">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Зберегти' : 'Зберегти',array('class'=>'btn btn-success')); ?>
</div>
    <br>

<?php $this->endWidget(); ?>
    <br>
    <br>
    <br> <br>
    <br>

    <br> <br>
    <br>

<!--</div>-->
<!--<div class="span10">-->
    <?php
    $form=$this->beginWidget('CActiveForm')?>
    <div class="span3">
        Від
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'name'=>'from_date',
            'language' => 'uk',
            'value' => Yii::app()->request->getPost('from_date'),
            'htmlOptions'=>array(
                'style'=>'height:20px;'
            ),
        ));?>
    </div>
    <div class="span3">
        &nbsp;До
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'name'=>'to_date',
            'language' => 'uk',
            'value' => Yii::app()->request->getPost('to_date'),
            'htmlOptions'=>array(
                'style'=>'height:20px;'
            ),
        ));?>
    </div>
    <div class="span3">
        <?php echo TbHtml::submitButton('Ок', array('class'=>''));?>
    </div>
    <?php $this->endWidget(); ?>
    <br>
    <br>
    <?php
    Yii::app()->getComponent('yiiwheels')->registerAssetJs('bootbox.min.js');
    $this->widget('yiiwheels.widgets.grid.WhGridView', array(
        'type' => 'striped bordered',
        'fixedHeader'=>true,
        'dataProvider' => $declarations,
        'template' => "{items}",
        'columns'=>array(
            array(
                'class' => 'CCheckBoxColumn',
            ),
            array(

                'header' => '№',
                'value' => '$row+1',

            ),

            'date' => array(
                'name' => 'date',
                'value' => 'date("d.m.Y", strtotime($data->date))'
            ),
            'courier',
           'declar_numb',
            'places_numb',
            'comment',
            array(
                'class' => 'CButtonColumn',
                'template' => '{update} {delete}',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("/admin/users/updateDeclaration",array("id"=>$data->id, "user_id" => $data->user_id))',
                'updateButtonImageUrl' => [],
                'updateButtonLabel' => 'Редагувати',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/admin/users/deleteDeclaration",array("id"=>$data->id, "user_id" => $data->user_id))',
                'deleteButtonImageUrl' => [],
                'deleteButtonLabel' => 'Видалити',
                'htmlOptions' => array('style' => 'width:10px')
            ),
        ),
    )); ?>

</div>
