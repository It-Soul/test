<?php $this->renderPartial('_menu',array('id'=>$user_id,'active'=> 'debit'));?>
<div class="span10">
    <?php echo TbHtml::well(Users::model()->getUserName($user_id), array('size' => TbHtml::WELL_SIZE_SMALL, 'style' => 'width:100%')); ?>
    <div style="text-align: left"
    <h5>Заборгованість
        складає: <?php echo $user->arrears ?> грн</h5>
    <h5>Замовлений товар:<?php echo Orders::model()->getUserSum_2($user_id, 0, 0)['price_out_sum'] ?> грн</h5>
    <h5>Виконується
        замовлення:<?php echo Orders::model()->getUserSumProcess($user_id, 1, 0, true)['price_out_sum'] + Orders::model()->getUserSumProcess($user_id, 1, 0, false)['price_out_sum'] ?>
        грн </h5>
    <div class="row">
        <div class="span3">
            <h3>Вибрати дату</h3>
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'messages-arrears-form',
                'enableAjaxValidation' => false,

            )); ?>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'arrears_date',
                'language' => 'uk',
                'value' => Yii::app()->request->getPost('arrears_date'),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            )); ?>
        </div>
        <div class="span5">
            <h3>Підтвердити оплату</h3>

            <?php echo $form->errorSummary($model); ?>
            <?php echo $form->hiddenField($model, 'user_id', array('value' => $user_id)); ?>
            <?php echo $form->textField($model, 'summa'); ?>
            <?php echo $form->error($model, 'summa'); ?>
            <?php echo CHtml::submitButton('Ок', array('class' => 'btn btn-primary', 'style' => 'margin-bottom: 10px;')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>
    <div class="row">

        <?php
        echo '<h4>Борг : ' . ($suma_buy - $suma_opl) . ' грн</h4>'; ?>


        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'method' => 'get'
        )) ?>
        Від
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'from_date',
            'language' => 'uk',
            'value' => Yii::app()->request->getQuery('from_date'),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        )); ?>


        &nbsp;До
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'to_date',
            'language' => 'uk',
            'value' => Yii::app()->request->getQuery('to_date'),
            'htmlOptions' => array(
                'style' => 'height:20px; margin-left: 59px;'
            ),
        )); ?>
        <?php echo TbHtml::submitButton('Ок', array('class' => 'btn btn-default', 'style' => 'margin-bottom: 10px;')); ?>
    </div>
    <?php $this->endWidget(); ?>
    <div class="row">

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
                        'url' => $this->createUrl('admin/users/suborders_2?user_id='.$user_id),
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

    <div class="row">
        <h4>Повідомлення про оплату</h4>

    <?php

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
</div>

</div>




