<?php $this->renderPartial('//admin/users/_menu', array('id' => $user->id)); ?>
<div class="span10">
    <?php echo TbHtml::well(Users::model()->getUserName($user->id), array('size' => TbHtml::WELL_SIZE_SMALL, 'style' => 'width:100%')); ?>
    <div>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'import-file-form',
//            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data')
        )); ?>
        <!--        --><?php //echo $form->errorSummary($model); ?>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'currency'); ?>
            <?php echo $form->dropDownList($model, 'currency', array('UAH' => "UAH", 'PLN' => 'PLN', 'EUR' => "EUR", 'USD' => 'USD'), array('prompt' => '', 'required' => true)); ?>
            <?php echo $form->error($model, 'currency'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('required' => true)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'file'); ?>
            <?php echo $form->fileField($model, 'file', array('required' => true)); ?>
            <?php echo $form->error($model, 'file'); ?>
        </div>

        <?php echo CHtml::submitButton('Завантажити', array('class' => 'btn btn-success')); ?>

        <?php $this->endWidget(); ?>
    </div>
</div>