<?php
/* @var $this CabinetController */

$this->breadcrumbs = array(
    'Редагування замовлення',
);
?>
<div class="row span10">
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'order-form',

        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>
    <table class="items table table-striped table-bordered">
        <tr>

            <td>
                Назва
            </td>
            <td>
                Номер запчастини
            </td>
            <td>
                Виробник
            </td>
            <td>
                Кількість
            </td>

            <td>
                Ціна грн
            </td>
            <td>
                Сума грн
            </td>
            <td>
            </td>
        </tr>
        <tr>

            <td style="width: 1500px">
                <?php echo $model->name ?>
            </td>
            <td>
                <?php echo $model->cod ?>
            </td>
            <td>
                <?php echo $model->manufacturer ?>
            </td>
            <td>
                <div class="row">

                    <?php echo $form->textField($model, 'quantity', array('style' => 'width:30px; margin-left: 35px')); ?>
                    <?php echo $form->error($model, 'quantity'); ?>
                </div>
            </td>
            <td>

                <?php echo $model->price_out; ?>


            </td>
            <td>

                <?php echo $model->price_out_sum; ?>


            </td>
            <td>
                <div class="row buttons">
                    <?php echo CHtml::submitButton('Зберегти', array('class' => 'btn btn-success', 'style' => 'margin-left: 35px; margin-bottom: 10px')) ?>
               </div>
            </td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>

</div><!-- form -->
</div><!-- form -->