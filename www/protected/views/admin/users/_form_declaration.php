<?php
/* @var $this DeclarationsController */
/* @var $model declarations */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'declarations-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row span3">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
			'name'=>'date',
			'language' =>'uk',
			'value' => $model->date,
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

	<?php echo $form->hiddenField($model,'user_id'); ?>


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
	<div class="row buttons span1 " style="margin-top:15px;margin-left:-170px">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Зберегти' : 'Зберегти',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->