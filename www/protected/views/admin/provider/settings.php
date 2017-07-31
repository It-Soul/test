<?php $this->renderPartial('//admin/users/_menu', array('id' => $user->id)); ?>
<div class="span10">
    <?php echo TbHtml::well(Users::model()->getUserName($user->id), array('size' => TbHtml::WELL_SIZE_SMALL, 'style' => 'width:100%')); ?>

    <?php if (Yii::app()->user->hasFlash('success')) { ?>

        <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success')); ?>

    <?php } ?>
    <?php if (Yii::app()->user->hasFlash('error')) { ?>

        <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_DANGER, Yii::app()->user->getFlash('error')); ?>

    <?php } ?>

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'provider-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>
    <?php echo $form->errorSummary($provider); ?>

    <div class="form-group">
        <?php echo $form->labelEx($provider, 'uploading_status'); ?>
        <?php echo $form->dropDownList($provider, 'uploading_status', array(0 => "Заблоковано", 1 => 'Розблоковано')); ?>
        <?php echo $form->error($provider, 'uploading_status'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($provider, 'updating_status'); ?>
        <?php echo $form->dropDownList($provider, 'updating_status', array(0 => "Заблоковано", 1 => 'Розблоковано')); ?>
        <?php echo $form->error($provider, 'updating_status'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($provider, 'allowed_products_amount'); ?>
        <?php echo $form->textField($provider, 'allowed_products_amount'); ?> шт.
        <?php echo $form->error($provider, 'allowed_products_amount'); ?>
    </div>

    <hr/>

    <div class="form-group">
        <?php echo $form->labelEx($provider, 'file_uploading_status'); ?>
        <?php echo $form->dropDownList($provider, 'file_uploading_status', array(0 => "Заблоковано", 1 => 'Розблоковано')); ?>
        <?php echo $form->error($provider, 'file_uploading_status'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($provider, 'file_updating_status'); ?>
        <?php echo $form->dropDownList($provider, 'file_updating_status', array(0 => "Заблоковано", 1 => 'Розблоковано')); ?>
        <?php echo $form->error($provider, 'file_updating_status'); ?>
    </div>

    <hr/>

    <div class="form-group">
        <?php echo $form->labelEx($provider, 'relevance_check_status'); ?>
        <?php echo $form->dropDownList($provider, 'relevance_check_status', array(0 => "Викл", 1 => 'Вкл')); ?>
        <?php echo $form->error($provider, 'relevance_check_status'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->textField($provider, 'data_count'); ?> днів
        <?php echo $form->error($provider, 'data_count'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($provider, 'status_country'); ?>
        <?php echo $form->dropDownList($provider, 'status_country', array(0 => "Викл", 1 => 'Вкл')); ?>
        <?php echo $form->error($provider, 'status_country'); ?>
    </div>

    <hr/>

    <h4>Країна клієнта: <?php echo $country->name ?></h4>

    <div class="form-group">
        <?php echo $form->labelEx($provider, 'country_logistic'); ?>
        <?php echo $form->textField($provider, 'country_logistic'); ?>
        <?php echo $form->error($provider, 'country_logistic'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($provider, 'status_hint'); ?>
        <?php echo $form->dropDownList($provider, 'status_hint', array(0 => "Викл", 1 => 'Вкл')); ?>
        <?php echo $form->error($provider, 'status_hint'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($provider, 'country_delivery'); ?>
        <?php echo $form->textField($provider, 'country_delivery'); ?> днів
        <?php echo $form->error($provider, 'country_delivery'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($provider, 'country_hint'); ?>
        <?php echo $form->textArea($provider, 'country_hint', array('rows' => 10)); ?>
        <?php echo $form->error($provider, 'country_hint'); ?>
    </div>

    <?php echo CHtml::submitButton('Зберегти зміни', array('class' => 'btn btn-success')); ?>

    <?php $this->endWidget(); ?>
</div>