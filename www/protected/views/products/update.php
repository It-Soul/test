<?php $this->renderPartial('_cabinetmenu'); ?>
<div class="span10">
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        </br><?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success')); ?>
    <?php endif; ?>

    <?php $this->renderPartial('_form', array('model' => $model, 'numbers' => $numbers)); ?>
</div>
