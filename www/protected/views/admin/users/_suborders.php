<?php
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'fixedHeader' => true,
    'type' => 'striped bordered',
    'dataProvider' => $orders,
    'template' => "{items}",
    'columns' => array(
        array(
            'header' => '№',
            'value' => '$row+1',
        ),

        'name' => array(
            'name' => 'name',
            'htmlOptions' => array('style' => 'width:150px; !important'),
        ),
        'cod',
        'manufacturer',
        'quantity' => array(
            'name' => 'quantity',
            'footer' => Orders::model()->getUserSumByDateLogistic($user->id, $invoice->date, 1, 1)['quantity'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
        ),
        array(
            'name' => 'manager',
            'header' => 'Менеджер',
            'footer' => Orders::model()->getUserSumByDateLogistic($user->id, $invoice->date, 1, 1)['manager'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->manager, 2, ',', '');
            }
        ),
        array(
            'name' => 'courier',
            'header' => 'Курат',
            'footer' => Orders::model()->getUserSumByDateLogistic($user->id, $invoice->date, 1, 1)['courier'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->courier, 2, ',', '');
            }
        ),
        array(
            'name' => 'admin',
            'header' => 'Адмін',
            'footer' => Orders::model()->getUserSumByDateLogistic($user->id, $invoice->date, 1, 1)['admin'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->admin, 2, ',', '');
            }
        ),


        'price_out',
        'price_out_sum' => array(
            'name' => 'price_out_sum',
            'footer' => 'Разом: ' . Orders::model()->getUserSumByDateLogistic($user->id, $invoice->date, 1, 1)['price_out_sum'] . 'грн',
            'footerHtmlOptions' => array('style' => ' background-color: #FFFF00'),
            'htmlOptions' => array('style' => 'width:150px; !important '),
        ),


    ),
));