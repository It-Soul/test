<div class="span3">
    <?php $this->widget('ext.mywidgets.Admin.EditorMenu'); ?>
</div>
<div class="span9">
    <h4>Управління візуалізації</h4>
    <?php

    if (Yii::app()->user->hasFlash('success')) {
        echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success'), array('style' => 'width:105%'));
    }

    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation' => false,
    ));

    $this->widget('ext.ckeditor.CKEditorWidget', array(
        "model" => $model,
        "attribute" => 'text',
        "defaultValue" => $model->text,
        "config" => array(
            "height" => "500px",
            "width" => "110%",
        ),
    ));
    echo '<br/>';
    echo CHtml::submitButton('Зберегти', array('class' => 'btn btn-success'));

    $this->endWidget();
    ?>
</div>
