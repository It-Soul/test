<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    <div class="span2">
        <div class="row">
            <?php echo $form->label($model, 'phone'); ?>
            <?php echo $form->textField($model, 'phone'); ?>
        </div>
    </div>

    <div class="span2">
        <div class="row" style="margin-left: 25px">
            <?php echo $form->label($model, 'email'); ?>
            <?php echo $form->textField($model, 'email'); ?>
        </div>
    </div>
    <div class="span2">
        <div class="row buttons" style="margin-left: 70px; margin-top: 25px">
            <?php echo CHtml::submitButton('Пошук', array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <!--	<div class="row">-->
    <!--		<label for="Users_reg_like">Діяльність</label>-->
    <!--		--><?php //echo $form->dropDownList($model,'reg_like',  array('Магазин' => 'Магазин', 'Сервіс' => 'Сервіс', 'Перевізник' => 'Перевізник / власник ТЗ'), array('prompt'=>''))?>
    <!--	</div>-->
    <!---->
    <!--	<div class="row">-->
    <!--		--><?php //echo $form->label($model,'opole'); ?>
    <!--		--><?php //echo $form->dropDownList($model,'opole',array(0=>"Не задано",1=>"Дрібний", 2=>"Середній", 3=>"Великий", 4=>"VIP"),  array('prompt' => '')); ?>
    <!--	</div>-->
    <!---->
    <!--	<div class="row">-->
    <!--		--><?php //echo $form->label($model,'region'); ?>
    <!--		--><?php //echo $form->dropDownList($model,'region', $regions, array('prompt' => ''))?>
    <!--	</div>-->
    <!---->
    <!--	<div class="row" id="city">-->
    <!--		--><?php //echo $form->label($model,'city'); ?>
    <!--		--><?php //echo $form->dropDownList($model, 'city',  $cities, array('prompt' => ''))?>
    <!--	</div>-->
    <!---->
    <!--	<div class="row">-->
    <!--		--><?php //echo $form->label($model,'role'); ?>
    <!--		--><?php //echo $form->dropDownList($model,'role',array('user'=>"Користувач", 'manager'=>'Менеджер','courier'=>'Куратор','administrator'=>"Адміністратор"),  array('prompt' => '')); ?>
    <!--	</div>-->
    <!---->
    <!--	<div class="row">-->
    <!--		--><?php //echo $form->label($model,'status'); ?>
    <!--		--><?php //echo $form->dropDownList($model,'status',array(0=>"Не підтверджений",1=>"Підтверджений", 2=>'Заблокований'),  array('prompt' => '')); ?>
    <!--	</div>-->
    <!--	<br/>-->
    <!--	<div class="row buttons">-->
    <!--		--><?php //echo CHtml::submitButton('Пошук', array('class' => 'btn btn-primary', 'style' => 'width: 220px')); ?>
    <!--	</div>-->

    <?php $this->endWidget(); ?>

</div><!-- search-form -->