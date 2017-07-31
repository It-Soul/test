<div class="span3">
    <?php $this->widget('ext.mywidgets.Admin.EditorMenu'); ?>
</div>

<div class="span9">
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success')); ?>
    <?php endif; ?>

    <h4>Коефіцієнти по замовчуванню</h4>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'users-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'style' => 'margin-left:50px'
        )
    )); ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'logistic'); ?>
        <?php echo $form->textField($model, 'logistic'); ?>
        <?php echo $form->error($model, 'logistic'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'vat'); ?>
        <?php echo $form->textField($model, 'vat'); ?>
        <?php echo $form->error($model, 'vat'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'manager_coef'); ?>
        <?php echo $form->textField($model, 'manager_coef'); ?>
        <?php echo $form->error($model, 'manager_coef'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'curator_coef'); ?>
        <?php echo $form->textField($model, 'curator_coef'); ?>
        <?php echo $form->error($model, 'curator_coef'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'admin_coef'); ?>
        <?php echo $form->textField($model, 'admin_coef'); ?>
        <?php echo $form->error($model, 'admin_coef'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', array('1' => 'Увімкнений', '0' => 'Вимкнений'), array('prompt' => '')) ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'site_name'); ?>
        <?php echo $form->dropDownList($model, 'site_name', $sites, array('prompt' => '')) ?>
        <?php echo $form->error($model, 'site_name'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Ок', array('class' => 'btn btn-success')); ?>
    </div>
    <?php $this->endWidget(); ?>


</div>


