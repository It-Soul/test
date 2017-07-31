<?php $this->renderPartial('_menu',array('id'=>$user_id,'active'=> 'orders'));?>
<div class="span10">
    <?php echo TbHtml::well(Users::model()->getUserName($user_id), array('size' => TbHtml::WELL_SIZE_SMALL, 'style' => 'width:100%')); ?>

    <?php

    if (!empty($orders)) {
        echo '<h3>Замовлено</h3>';
        foreach ($orders as $results => $value) {
            echo '<span style="font-size:18px; font-weight: bold; margin-left:15px">' . date('d.m.Y', strtotime($results)) . '</span>';
            Yii::app()->getComponent('yiiwheels')->registerAssetJs('bootbox.min.js');
            $this->widget('yiiwheels.widgets.grid.WhGridView', array(
                'type' => 'striped bordered',
                'dataProvider' => $value,
                'template' => "{items}",
                'fixedHeader' => true,
                'columns' => array(
                    array(
                        'class' => 'CCheckBoxColumn',
                    ),
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
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['quantity'] + Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['quantity'],
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
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['price_out_sum'] +  Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['price_out_sum'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->price_out_sum, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'price_in_sum',
                        'header' => 'Сума PLN',
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['price_in_sum'] +  Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['price_in_sum'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->price_in_sum, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'com_course',
                        'header' => 'Ком. курс',
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['com_course'] + Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['com_course'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->com_course, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'vat',
                        'header' => 'VAT',
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['vat'] + Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['vat'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->vat, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'logistic_pln',
                        'header' => 'Логістс PLN',
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['logistic_pln'] + Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['logistic_pln'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->logistic_pln, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'logistic_grn',
                        'header' => 'Логіст грн',
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['logistic_grn'] + Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['logistic_grn'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->logistic_grn, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'com_grn',
                        'header' => 'Ком грн',
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['com_grn'] + Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['com_grn'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->com_grn, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'logist_pln',
                        'header' => 'Логіст PLN',
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['logist_pln'] + Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['logist_pln'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->logist_pln, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'manager',
                        'header' => 'Менеджер',
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['manager'] +  Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['manager'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->manager, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'courier',
                        'header' => 'Курат',
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['courier'] +  Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['courier'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->courier, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'admin',
                        'header' => 'Адмін',
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['admin'] + Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['admin'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->admin, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'course',
                        'header' => 'Курс різниця',
                        'footer' => Orders::model()->getUserSumByDateOrdered($user_id, $results,0,0,0)['course'] + Orders::model()->getUserSumByDateOrdered($user_id, $results,1,0)['course'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->course, 2, ',', '');
                        }
                    ),

                ),
            ));
        }
    } ?>
    <?php
    if(!empty($orders_3)) {
        echo '	<h3>Доопрацювання не привезених позицій</h3>';
        foreach ($orders_3 as $results => $value) {
            echo '<span style="font-size:18px; font-weight: bold; margin-left:15px">' . date('d.m.Y',strtotime($results))  . '</span>';
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
                        'header' => 'Назва',
                        'htmlOptions' => array('style' => 'width:150px; !important'),
                    ),
                    array(
                        'name' => 'cod',
                        'header' => 'Номер запчастини',
                    ),
                    'manufacturer'=>array(
                        'name' => 'manufacturer',
                        'header' => 'Виробник',
                    ),
                    array(
                        'name' => 'quantity',
                        'header' => 'Кількість',
                        'footer' => 'Разом: ' . Orders::model()->getUserSumByDateCompletion($user_id, $results)['quantity'],
                        'footerHtmlOptions' => array('style' => ' background-color: #FFFF00'),
                    ),
                    'price_in' => array(
                        'header' => 'Ціна PLN',
                        'value' => function ($data) {
                            return number_format($data->price_in, 2, ',', '');
                        }
                    ),

                    'price_out' => array(
                        'name' => 'price_out_sum',
                        'header'=>'Ціна'
                    ),
                    'price_out_sum' => array(
                        'name' => 'price_out_sum',
                        'header'=>'Сума',
                        'footer' => 'Разом: ' . Orders::model()->getUserSumByDateCompletion($user_id, $results)['price_out_sum'] . ' грн',
                        'footerHtmlOptions' => array('style' => ' background-color: #FFFF00'),
                        'htmlOptions' => array('style' => 'width:150px; !important '),
                    ),
                    array(
                        'name' => 'price_in_sum',
                        'header' => 'Сума PLN',
                        'footer' => Orders::model()->getUserSumByDateCompletion($user_id, $results)['price_in_sum'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->price_in_sum, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'com_course',
                        'header' => 'Ком. курс',
                        'footer' => Orders::model()->getUserSumByDateCompletion($user_id, $results)['com_course'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->com_course, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'vat',
                        'header' => 'VAT',
                        'footer' => Orders::model()->getUserSumByDateCompletion($user_id, $results)['vat'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->vat, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'logistic_pln',
                        'header' => 'Логістс PLN',
                        'footer' => Orders::model()->getUserSumByDateCompletion($user_id, $results)['logistic_pln'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->logistic_pln, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'logistic_grn',
                        'header' => 'Логіст грн',
                        'footer' => Orders::model()->getUserSumByDateCompletion($user_id, $results)['logistic_grn'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->logistic_grn, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'com_grn',
                        'header' => 'Ком грн',
                        'footer' => Orders::model()->getUserSumByDateCompletion($user_id, $results)['com_grn'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->com_grn, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'logist_pln',
                        'header' => 'Логіст PLN',
                        'footer' => Orders::model()->getUserSumByDateCompletion($user_id, $results)['logist_pln'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->logist_pln, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'manager',
                        'header' => 'Менеджер',
                        'footer' => Orders::model()->getUserSumByDateCompletion($user_id, $results)['manager'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->manager, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'courier',
                        'header' => 'Курат',
                        'footer' => Orders::model()->getUserSumByDateCompletion($user_id, $results)['courier'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->courier, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'admin',
                        'header' => 'Адмін',
                        'footer' => Orders::model()->getUserSumByDateCompletion($user_id, $results)['admin'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->admin, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'course',
                        'header' => 'Курс різниця',
                        'footer' => Orders::model()->getUserSumByDateCompletion($user_id, $results)['course'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return number_format($data->course, 2, ',', '');
                        }
                    ),
//                    array(
//                        'header' => '',
//                        'type' => 'raw',
//                        'value' => function ($data) {
//                            return '<a href="/cabinet/deleteOrder?id=' . $data->id . '" class="btn btn-danger" id="order" data-id="' . $data->id . '">Видалити</button>';
//                        },
//                        'htmlOptions' => array('style' => 'width:5%; !important '),
//                    ),

                ),
            ));
        }
    }?>
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
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
                    'url' => $this->createUrl('/admin/users/suborders?user_id=' . $user_id),
                    'value' => function ($data) {
                        return date('d.m.Y', strtotime($data->date));
                    },
                )
            ), array(
                'quantity' => array(
                    'header' => 'Кількість',
                    'value' => function ($data) {
                        return Orders::model()->getUserSumByDate($this->user_id, $data->date)['quantity'];
                    }
                ),
                'sum' => [
                    'header' => 'Сума',
                    'value' => function ($data) {
                        return Orders::model()->getUserSumByDate($this->user_id, $data->date)['price_out_sum'];
                    }
                ]
            )),
        ));
    } ?>
    <h3>Накладні</h3>
    <div class="row">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'method' => 'get'
        )) ?>
        <div class="span3">
            Від
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'from_date_3',
                'language' => 'uk',
                'value' => Yii::app()->request->getPost('from_date_3'),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            )); ?>
        </div>
        <div class="span3">
            &nbsp;До
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'to_date_3',
                'language' => 'uk',
                'value' => Yii::app()->request->getPost('to_date_3'),
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
    <br/>
    <?php
    $this->widget('yiiwheels.widgets.grid.WhGridView', array(
        'type' => 'striped bordered',
        'dataProvider' => $invoices,
        'template' => "{items}",
        'columns' => array_merge(array(
            array(
                'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                'header' => '№ накладної',
                'cacheData' => false,
                'url' => $this->createUrl('/admin/users/suborders?user_id=' . $user_id),
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
            ],


        )),
    )); ?>
</div>