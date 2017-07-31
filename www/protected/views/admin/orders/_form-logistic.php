<?php
/* @var $this OrdersController */
/* @var $model Orders */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'orders-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <?php if (Yii::app()->user->hasFlash('success')) { ?>
        <div class="row" style="width: 90%">
            <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success')); ?>
        </div>
    <?php } ?>
    <?php if (Yii::app()->user->hasFlash('danger')) { ?>
        <div class="row" style="width: 90%">
            <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, $form->errorSummary($model)); ?>
        </div>
    <?php } ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'received'); ?>
        <?php echo $form->textField($model, 'received'); ?>
        <?php echo $form->error($model, 'received'); ?>
    </div>

    <!--	<div class="row">-->
    <!--		--><?php //echo $form->labelEx($model,'name'); ?>
    <!--		--><?php //echo $form->textArea($model,'name',array('rows'=>6, 'cols'=>50)); ?>
    <!--		--><?php //echo $form->error($model,'name'); ?>
    <!--	</div>-->
    <!---->
    <!--	<div class="row">-->
    <!--		--><?php //echo $form->labelEx($model,'cod'); ?>
    <!--		--><?php //echo $form->textField($model,'cod',array('size'=>50,'maxlength'=>50)); ?>
    <!--		--><?php //echo $form->error($model,'cod'); ?>
    <!--	</div>-->
    <!---->
    <!--	<div class="row">-->
    <!--		--><?php //echo $form->labelEx($model,'status'); ?>
    <!--		--><?php //echo $form->textField($model,'status'); ?>
    <!--		--><?php //echo $form->error($model,'status'); ?>
    <!--	</div>-->
    <!---->
    <!--	<div class="row">-->
    <!--		--><?php //echo $form->labelEx($model,'image'); ?>
    <!--		--><?php //echo $form->textField($model,'image',array('size'=>60,'maxlength'=>100)); ?>
    <!--		--><?php //echo $form->error($model,'image'); ?>
    <!--	</div>-->
    <!---->
    <!--	<div class="row">-->
    <!--		--><?php //echo $form->labelEx($model,'user_name'); ?>
    <!--		--><?php //echo $form->textArea($model,'user_name',array('rows'=>6, 'cols'=>50)); ?>
    <!--		--><?php //echo $form->error($model,'user_name'); ?>
    <!--	</div>-->

    <div class="row">
        <?php echo $form->labelEx($model, 'ordered'); ?>
        <?php echo $form->dropDownList($model, 'ordered', array('0' => 'Ні', '1' => 'Так')) ?>
        <?php echo $form->error($model, 'ordered'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'send'); ?>
        <?php echo $form->dropDownList($model, 'send', array('0' => 'Ні', '1' => 'Так')) ?>
        <?php echo $form->error($model, 'send'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Зберегти', array('class' => 'btn btn-success')); ?>
        <!--		--><?php //echo CHtml::link('Видалити', $this->createUrl('/admin/orders/delete', array('id' => $model->id)), array('class' => 'btn btn-danger', 'data-method' => 'POST')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->