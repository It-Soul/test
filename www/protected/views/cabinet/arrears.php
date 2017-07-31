<div class="span12">
<?php
/* @var $this messagesController */
/* @var $model messages */
/* @var $form CActiveForm */

$this->breadcrumbs = array(
    'Мій кабінет' => array('/cabinet'),
    'Заборгованість',
);
?>

    <div class="row">
        <div class="span3">
            <?php
            if(Yii::app()->user->hasFlash('arrears')): ?>
            </br>
            <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('arrears')); ?>
            <?php else: ?>
            <?php endif; ?>
        </div>
    </div>
    <h3>Повідомити про оплату</h3>
    <div class="row span12">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'messages-arrears-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // See class documentation of CActiveForm for details on this,
            // you need to use the performAjaxValidation()-method described there.
            'enableAjaxValidation' => false,
        )); ?>

        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php echo $form->textField($model, 'text'); ?>
        <?php echo $form->error($model, 'text'); ?>
        <?php echo CHtml::submitButton('Ок',array('class'=>'btn','style'=>'margin-bottom: 10px;')); ?>


        <?php $this->endWidget(); ?>
    </div>
    <!-- form -->
<div class="row">
    <div class="row span4 well">
        <?php
        if (!empty($arrears)) {
            echo '<h5>Заборгованість складає:' . $arrears . ' грн</h5>';
        }
        ?>
        <h5>Заборгованість
            складає: <?php echo $suma_buy - $suma_opl; ?> грн</h5>
        <h5>Замовлений товар: <?php echo Orders::model()->getUserSum_2(Yii::app()->user->id, 0, 0)['price_out_sum'] ?>
            грн</h5>
        <h5>Виконується
            замовлення: <?php echo Orders::model()->getUserSumProcess(Yii::app()->user->id, 1, 0, true)['price_out_sum'] + Orders::model()->getUserSumProcess(Yii::app()->user->id, 1, 0, false)['price_out_sum'] ?>
            грн </h5>

    </div>
    </div>
    <br>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'method' => 'get'
    )) ?>
    Від
    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name' => 'from_date_2',
        'language' => 'uk',
        'value' => Yii::app()->request->getQuery('from_date_2'),
        'htmlOptions' => array(
            'style' => 'height:20px;'
        ),
    )); ?>


    &nbsp;До
    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name' => 'to_date_2',
        'language' => 'uk',
        'value' => Yii::app()->request->getQuery('to_date_2'),
        'htmlOptions' => array(
            'style' => 'height:20px; margin-left: 59px;'
        ),
    )); ?>
    <?php echo TbHtml::submitButton('Ок', array('class' => 'btn btn-default','style' => 'margin-bottom: 10px;')); ?>
</div>
<?php $this->endWidget(); ?>
<div class="row span8">

    <?php
    if (!empty($dataProvider)) {

        $this->widget('yiiwheels.widgets.grid.WhGridView', array(
            'type' => 'striped bordered',
            'dataProvider' => $dataProvider,
            'template' => "{items}",
            'columns' => array_merge(array(
                array(
                    'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                    'header' => 'Дата',
                    'url' => $this->createUrl('cabinet/suborders_2'),
                    'value' => function ($data) {
                        return date('d-m-Y', strtotime($data->date));
                    },
                )
            ), array(
                array(
                    'header' => 'Купив',
                    'value' => function ($data) {
                        $message = '0 грн';
                        if ($data->status == 1) {
                            $message = Orders::model()->getUserSumByDateLogistic($data->user_id, $data->date, 1, 1)['price_out_sum'] . ' грн';
                        }
                        return $message;
                    },
                    'footer' => $suma_buy . ' грн',
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),

                ),
                array(
                    'header' => 'Оплатив',
                    'value' => function ($data) {
                        $message = '0 грн';
                        if ($data->status == 0) {
                            $message = $data->summa . ' грн';
                        }
                        return $message;
                    },
                    'footer' => $suma_opl . ' грн',
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                ),

            )),
        ));
    }
    ?>
    </div>
    <div class="row span8">
        <?php
        echo '<h4>Повідомлення про оплату</h4>';
        if (!empty($dataProvider_2)) {
            Yii::app()->getComponent('yiiwheels')->registerAssetJs('bootbox.min.js');
            $this->widget('yiiwheels.widgets.grid.WhGridView', array(
                'type' => 'striped bordered',
                'fixedHeader' => true,
                'dataProvider' => $dataProvider_2,
                'template' => "{items}",
                'columns' => array(
                    array(
                        'class' => 'CCheckBoxColumn',
                    ),
                    'date' => array(
                        'header' => 'Дата',
                        'value' => function ($value) {
                            return date('d-m-Y H:i', strtotime($value->date));
                        }
                    ),
                    'text'

                ),
            ));
        }
        ?>
</div>
