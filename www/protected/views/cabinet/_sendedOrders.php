<?php
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'type' => 'striped bordered',
    'fixedHeader' => true,
    'dataProvider' => $orders,
    'template' => "{items}",
    'rowCssClass' => array('odd', 'setRedColor'),
    'rowCssClassExpression' => '$data->completion==1?$this->rowCssClass[1]:$this->rowCssClass[0]',
    'columns' => array(
//        array(
//            'class' => 'CCheckBoxColumn',
//        ),
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
            'footer' => 'Разом: ' . Orders::model()->getUserSumByDate(Yii::app()->user->id, $date)['quantity'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00')
        ),

        array(
            'name' => 'price_out',
            'header' => 'Ціна грн',

        ),
        array(
            'name' => 'price_out_sum',
            'header' => 'Сума грн',
            'footer' => 'Разом: ' . Orders::model()->getUserSumByDate(Yii::app()->user->id, $date)['price_out_sum'] . ' грн',
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