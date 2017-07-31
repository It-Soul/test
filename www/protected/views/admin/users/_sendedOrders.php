<?php
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'type' => 'striped bordered',
    'dataProvider' => $orders,
    'template' => "{items}",
    'fixedHeader' => true,
    'columns' => array(
        array(
            'header' => '№',
            'value' => '$row+1',
        ),
        array(
            'name' => 'provider',
            'header' => 'Постачальник',
            'value' => function ($data) {
                switch ($data->provider) {
                    case    'http://webcatalog.opoltrans.com.pl/':
                        return 'Ополь';
                        break;
                    case    'http://sklep.martextruck.pl/':
                        return 'Мартекс';
                        break;
                    case    'http://www.intercars.com.pl/':
                        return 'Інтеркарс';
                        break;
                    case    'http://sklep.skuba.com.pl':
                        return 'Скуба';
                        break;
                }
            }
        ),
        'name' => array(
            'name' => 'name',
            'header' => 'Назва запчастини',
            'htmlOptions' => array('style' => 'width:150px; !important'),
        ),
        array(
            'name' => 'cod',
            'header' => 'Номер запчастини',
        ),
        array(
            'name' => 'manufacturer',
            'header' => 'Виробник',
        ),
        array(
            'name' => 'quantity',
            'header' => 'К-cть',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['quantity'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00')
        ),

        'price_in' => array(
            'header' => 'Ціна PLN',
            'value' => function ($data) {
                return number_format($data->price_in, 2, ',', '');
            }
        ),
        array(
            'name' => 'price_out',
            'header' => 'Ціна грн.',
            'value' => function ($data) {
                return number_format($data->price_out, 2, ',', '');
            }
        ),
        array(
            'name' => 'price_out_sum',
            'header' => 'Сума грн.',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['price_out_sum'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->price_out_sum, 2, ',', '');
            }
        ),
        array(
            'name' => 'price_in_sum',
            'header' => 'Сума PLN',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['price_in_sum'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->price_in_sum, 2, ',', '');
            }
        ),
        array(
            'name' => 'com_course',
            'header' => 'Ком. курс',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['com_course'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->com_course, 2, ',', '');
            }
        ),
        array(
            'name' => 'vat',
            'header' => 'VAT',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['vat'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->vat, 2, ',', '');
            }
        ),
        array(
            'name' => 'logistic_pln',
            'header' => 'Логістс PLN',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['logistic_pln'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->logistic_pln, 2, ',', '');
            }
        ),
        array(
            'name' => 'logistic_grn',
            'header' => 'Логіст грн',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['logistic_grn'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->logistic_grn, 2, ',', '');
            }
        ),
        array(
            'name' => 'com_grn',
            'header' => 'Ком грн',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['com_grn'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->com_grn, 2, ',', '');
            }
        ),
        array(
            'name' => 'logist_pln',
            'header' => 'Логіст PLN',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['logist_pln'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->logist_pln, 2, ',', '');
            }
        ),
        array(
            'name' => 'manager',
            'header' => 'Менеджер',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['manager'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->manager, 2, ',', '');
            }
        ),
        array(
            'name' => 'courier',
            'header' => 'Курат',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['courier'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->courier, 2, ',', '');
            }
        ),
        array(
            'name' => 'admin',
            'header' => 'Адмін',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['admin'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->admin, 2, ',', '');
            }
        ),
        array(
            'name' => 'course',
            'header' => 'Курс різниця',
            'footer' => Orders::model()->getUserSumByDate($user_id, $date)['course'],
            'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
            'value' => function ($data) {
                return number_format($data->course, 2, ',', '');
            }
        ),

    ),
));