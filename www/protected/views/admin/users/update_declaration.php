<?php
/* @var $this DeclarationsController */
/* @var $model declarations */
?>

<h3>Редагування декларації № <?php echo $model->declar_numb; ?></h3>

<?php $this->renderPartial('_form_declaration', array('model'=>$model)); ?>