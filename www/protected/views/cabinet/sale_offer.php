<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$this->breadcrumbs=array(
    'Мій кабінет'=>array('/cabinet'),
    'Продажа поштучно',
);
?>
<br>



<div class="span4" >
    <div class="row span2">
        <?php $this->renderPartial('_cabinetmenu'); ?>
    </div>
    </div>
<div class="span5">
    <?php
    if(Yii::app()->user->hasFlash('sale_offer')): ?>
    </br>
    <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('sale_offer')); ?>
    <?php else: ?>
    <?php endif; ?>
</div>
<div class="span2">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'results_add-form',
    'enableClientValidation'=>true,

    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>
<?php //echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'cod'); ?>
        <?php echo $form->textField($model,'cod'); ?>
        <?php echo $form->error($model,'cod'); ?>
    </div>
<div class="row">
    <?php echo $form->labelEx($model,'name'); ?>
    <?php echo $form->textField($model,'name'); ?>
    <?php echo $form->error($model,'name'); ?>
</div>



<div class="row">
    <?php echo $form->labelEx($model,'manufacturer'); ?>
    <?php echo $form->textField($model,'manufacturer'); ?>
    <?php echo $form->error($model,'manufacturer'); ?>
</div>



<div class="row">
    <?php echo $form->labelEx($model,'state'); ?>
    <?php echo $form->textField($model,'state'); ?>
    <?php echo $form->error($model,'state'); ?>
</div>

<div class="row" >
    <?php echo $form->labelEx($model,'price'); ?>
    <?php echo $form->textField($model,'price');?>
    <?php echo $form->error($model,'price'); ?>
</div>
    <div class="row" id="column_add" >
        <?php echo $form->labelEx($model_2,'number'); ?>
        <?php echo $form->textField($model_2,'number[]',array('id'=>'input_add'));?>
        <?php echo $form->error($model_2,'number[]'); ?>

    </div>
    <?php echo CHtml::Button('Додати', array('class' => 'btn btn-success','id' =>'button_add')); ?>
    <div class="row" >
        <?php echo $form->labelEx($model,'image'); ?>
        <?php echo CHtml::activeFileField($model,'image');?>
        <?php echo $form->error($model,'image'); ?>
    </div>



    <div class="row buttons">
        <?php echo CHtml::submitButton('Зберегти', array('class' => 'btn btn-success')); ?>
    </div>

</div>
</form>


    <?php $this->endWidget(); ?>
</div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script>
$('#button_add').click(function(){


    $('#column_add').append('<div>' + '<input id="input_add" name="Numbers_add[number][]" type="text">' + '<input type="button" value="Видалити" id="button_delete"><br><br></div>');




});

$('#button_delete').live('click', function(){

    //$(this).siblings('#input_add').remove();
    $(this).parent().remove();
});


</script>