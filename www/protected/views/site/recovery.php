<h1>Відновлення паролю</h1>
<?php if(Yii::app()->user->hasFlash('error')): ?>
</br>
<div class="alert alert-danger">
	<?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('recovery')): ?>
</br>
<div class="alert alert-success">
	<?php echo Yii::app()->user->getFlash('recovery'); ?>
</div>
<?php endif; ?>
<p>Введіть email вказаний при реєстрації</p>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'recovery-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>
<?php echo CHtml::emailField('email', '', array('placeholder'=>'Введіть email'));?><br/>
<?php echo CHtml::submitButton('Відправити', array('class'=>'btn btn-primary'))?>

<?php $this->endWidget(); ?>
