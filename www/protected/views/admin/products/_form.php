<?php
/* @var $this ProductsController */
/* @var $model Results_add */
/* @var $form CActiveForm */
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'results-add-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<?php echo $form->errorSummary($model); ?>
<table class="items table table-striped table-bordered">
    <tr>
        <td>
            Зображення
        </td>
        <td>
            Назва
        </td>
        <td>
            Виробник
        </td>
        <td>
            Ціна
        </td>
        <td>
            Наявність
        </td>
    </tr>
    <tr>
        <td>
            <?php if ($model->photo) { ?>
                <img src="<?php echo $model->photo ?>" width="300"
                     height="200">
            <?php } else { ?>
                <img src="/<?php echo Yii::getPathOfAlias('photos') ?>/Nophoto.jpg" width="300" height="200">
            <?php } ?>

            <?php echo $form->fileField($model, 'image'); ?>
        </td>
        <td>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255,'required' =>true)); ?>
            <?php echo $form->textField($model, 'cod', array('size' => 60, 'maxlength' => 255, 'style' => 'width: 150px','required' =>true)); ?>
            <?php echo $form->textField($model, 'weight', array('style' => 'width: 60px')); ?>
        </td>
        <td>
            <?php echo $form->textField($model, 'manufacturer', array('size' => 60, 'maxlength' => 255, 'style' => 'width: 100px','required' =>true)); ?>
        </td>
        <td>
            <?php echo $form->textField($model, 'price', array('style' => 'width: 50px','required' =>true)); ?>
            <?php echo $form->dropDownList($model, 'currency', array('UAH' => "UAH", 'PLN' => 'PLN', 'EUR' => "EUR", 'USD' => 'USD'), array('style' => 'width: 65px')); ?>
        </td>
        <td>
            <?php echo $form->textField($model, 'state', array('size' => 60, 'maxlength' => 255, 'style' => 'width: 50px')); ?>
        </td>
    </tr>
</table>
<div id="column_add">
    <?php if (isset($numbers) && !empty($numbers)) {
        foreach ($numbers as $number) { ?>
            <div>
                <input id="input_add" name="Numbers_add[number][]" type="text" value="<?php echo $number->number ?>">
                <input type="button" value="Видалити" id="button_delete" class="btn btn-danger"
                       style="margin-top: -10px">
                <br><br>
            </div>
        <?php }
    } ?>
</div>
<?php echo CHtml::Button('Додати номер', array('class' => 'btn btn-primary pull-right', 'id' => 'button_add')); ?>
<br/>
<br/>

<div class="buttons">
    <?php echo CHtml::submitButton('Зберегти', array('class' => 'btn btn-success')); ?>
</div>

<?php $this->endWidget(); ?>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script>
    $('#button_add').click(function () {
        $('#column_add').append('<div><input id="input_add" name="Numbers_add[number][]" type="text">' + ' <input type="button" value="Видалити" id="button_delete" class="btn btn-danger" style="margin-top: -10px" "><br><br></div>');
    });

    $('#button_delete').live('click', function () {
        //$(this).siblings('#input_add').remove();
        $(this).parent().remove();
    });
</script>
