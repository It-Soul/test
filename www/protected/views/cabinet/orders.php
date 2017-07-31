<?php
/* @var $this CabinetController */

$this->breadcrumbs = array(
    'Мій кабінет' => array('/cabinet'),
    'Мої замовлення',
);
?>

<div class="row span12">
    <?php
    if (!empty($todayOrders)) {
        echo '	<h3>Замовлено</h3>';
        foreach ($todayOrders as $results => $value) {

            echo '<span style="font-size:18px; font-weight: bold; margin-left:15px">' . date('d.m.Y', strtotime($results)) . '</span>';
            $this->widget('yiiwheels.widgets.grid.WhGridView', array(
                'type' => 'striped bordered',
                'fixedHeader' => true,
                'dataProvider' => $value,
                'template' => "{items}",

                'columns' => array(
                    array(
                        'header' => '№',
                        'value' => '$row+1',
                    ),


                    'name' => array(
                        'name' => 'name',
                        'header' => 'Назва',
                        'htmlOptions' => array('style' => 'width:150px; !important'),
                    ),

                    array(
                        'name' => 'manufacturer',
                        'header' => 'Виробник'
                    ),

                    array(
                        'name' => 'quantity',
                        'header' => 'Кількість',
                        'type' => 'raw',
                        'footer' => 'Разом: ' . (Orders::model()->getUserSumByDateOrdered(Yii::app()->user->id, $results, 0, 0, 0)['quantity'] + Orders::model()->getUserSumByDateOrdered(Yii::app()->user->id, $results, 1, 0)['quantity']),
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00')
                    ),

                    array(
                        'name' => 'price_out',
                        'header' => 'Ціна грн',

                    ),
                    array(
                        'name' => 'price_out_sum',
                        'header' => 'Сума грн',
                        'footer' => 'Разом: ' . (Orders::model()->getUserSumByDateOrdered(Yii::app()->user->id, $results, 0, 0, 0)['price_out_sum'] + Orders::model()->getUserSumByDateOrdered(Yii::app()->user->id, $results, 1, 0)['price_out_sum']) . ' грн',
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00')
                    ),
                    array(
                        'header' => 'Статус',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->ordered == 1 ? '<strong>Опрацьовано</strong>' : CHtml::link('Редагувати', '/cabinet/editOrders?id=' . $data->id, array('class' => 'btn btn-default'));
                        },
                        'htmlOptions' => array('style' => 'width:5%')
                    ),

                ),
            ));

        }
    }
    ?>
    <?php
    if (!empty($orders_3)) {
        echo '	<h3>Доопрацювання не привезених позицій</h3>';
        foreach ($orders_3 as $results => $value) {
            echo '<span style="font-size:18px; font-weight: bold; margin-left:15px">' . date('d.m.Y', strtotime($results)) . '</span>';
            Yii::app()->getComponent('yiiwheels')->registerAssetJs('bootbox.min.js');
            $this->widget('yiiwheels.widgets.grid.WhGridView', array(
                'fixedHeader' => true,
                'type' => 'striped bordered',
                'dataProvider' => $value,
                'template' => "{items}",

                'columns' => array(
                    array(
                        'header' => '№',
                        'value' => '$row+1',
                    ),

                    'name' => array(
                        'name' => 'name',
                        'header' => 'Назва',
                        'htmlOptions' => array('style' => 'width:150px; !important'),
                    ),

                    'manufacturer' => array(
                        'name' => 'manufacturer',
                        'header' => 'Виробник',
                    ),
                    array(
                        'name' => 'quantity',
                        'header' => 'Кількість',
                        'footer' => 'Разом: ' . Orders::model()->getUserSumByDateCompletion(Yii::app()->user->id, $results)['quantity'],
                        'footerHtmlOptions' => array('style' => ' background-color: #FFFF00'),
                    ),


                    'price_out' => array(
                        'name' => 'price_out_sum',
                        'header' => 'Ціна'
                    ),
                    'price_out_sum' => array(
                        'name' => 'price_out_sum',
                        'header' => 'Сума',
                        'footer' => 'Разом: ' . Orders::model()->getUserSumByDateCompletion(Yii::app()->user->id, $results)['price_out_sum'] . ' грн',
                        'footerHtmlOptions' => array('style' => ' background-color: #FFFF00'),
                        'htmlOptions' => array('style' => 'width:150px; !important '),
                    ),
                    array(
                        'header' => '',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<a href="/cabinet/deleteOrder?id=' . $data->id . '" class="btn btn-danger" id="order" data-id="' . $data->id . '">Видалити</button>';
                        },
                        'htmlOptions' => array('style' => 'width:5%; !important '),
                    )

                ),
            ));
        }
    } ?>

    <h3>Історія замовленнь</h3>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'method' => 'get'
    )) ?>
    <div class="span3">
        Від
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'from_date_2',
            'language' => 'uk',
            'value' => Yii::app()->request->getQuery('from_date_2'),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        )); ?>
    </div>
    <div class="span3">
        &nbsp;До
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'to_date_2',
            'language' => 'uk',
            'value' => Yii::app()->request->getQuery('to_date_2'),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        )); ?>
    </div>
    <div class="span3">
        <?php echo TbHtml::submitButton('Ок', array('class' => '')); ?>
    </div>
    <?php $this->endWidget(); ?>
    <br/>
    <br/>
    <?php
    if (!empty($datesHistory)) {
        $this->widget('yiiwheels.widgets.grid.WhGridView', array(
            'type' => 'striped bordered',
            'dataProvider' => $datesHistory,
            'template' => "{items}",
            'columns' => array_merge(array(
                array(
                    'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                    'cacheData' => false,
                    'header' => 'Дата',
                    'name' => 'date',
                    'url' => $this->createUrl('cabinet/suborders'),
                    'value' => function ($data) {
                        return date('d.m.Y', strtotime($data->date));
                    },
                )
            ), array(
                'quantity' => array(
                    'header' => 'Кількість',
                    'value' => function ($data) {
                        return Orders::model()->getUserSumByDate(Yii::app()->user->id, $data->date)['quantity'];
                    }
                ),
                'sum' => [
                    'header' => 'Сума',
                    'value' => function ($data) {
                        return Orders::model()->getUserSumByDate(Yii::app()->user->id, $data->date)['price_out_sum'];
                    }
                ]
            )),
        ));

    }
    ?>
</div>

<div class="span12" style="margin-left: 0px">
<div class="row span12">
    <h3>Накладні</h3>

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'method' => 'get'
        )) ?>
        <div class="span3">
            Від
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'from_date',
                'language' => 'uk',
                'value' => Yii::app()->request->getPost('from_date'),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            )); ?>
        </div>
        <div class="span3">
            &nbsp;До

            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'to_date',
                'language' => 'uk',
                'value' => Yii::app()->request->getPost('to_date'),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            )); ?>
        </div>

        <div class="span3">
            <?php echo TbHtml::submitButton('Ок', array('class' => '')); ?>
        </div>
        <?php $this->endWidget(); ?>

</div>

  <div class="row span12">
    <?php
    $this->widget('yiiwheels.widgets.grid.WhGridView', array(
        'type' => 'striped bordered',
        'dataProvider' => $invoices,
        'id' => 'invoices',
        'template' => "{items}",
        'columns' => array_merge(array(
            array(
                'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                'header' => '№ накладної',
                'cacheData' => false,
                'name' => 'id',
                'url' => $this->createUrl('/cabinet/suborders'),
                'value' => function ($data) {
                    return $data->id;
                },
            )
        ), array(
            'date' => array(
                'name' => 'date',
                'value' => function ($data) {
                    return date('d.m.Y', strtotime($data->date));
                }
            ),
            'sum' => [
                'header' => '',
                'value' => function ($data) {
                    return Orders::model()->getUserSumByDateLogistic($data->user_id, $data->date, 1, 1)['price_out_sum'];
                }
            ]
        )),
    )); ?>
</div>
</div>
</div>