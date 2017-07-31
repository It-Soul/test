<?php
/* @var $this OrdersController */
/* @var $model Orders */


$this->menu = array(
    array('label' => 'На головну', 'url' => array('/admin/site/index')),
    array('label' => 'Створити замовлення', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#orders-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1>Логістика</h1>

<div class="span2">
    <div class="well" style="max-width: 340px; padding: 8px 0;">
        <?php echo TbHtml::navList(array(
            array('label' => 'Замовлення <span class="red">' . count(Orders::model()->findAllByAttributes(array('ordered' => 0, 'completion' => 0))) . '</span>', 'url' => '/admin/orders'),
            array('label' => 'Логістика <span class="red">' . count(Orders::model()->findAllByAttributes(array('ordered' => 1, 'send' => 0))) . '</span>', 'url' => '/admin/orders/logistic', 'active' => true),
            array('label' => 'Доопрацювання <span class="red">' . $notMatchLogistic . '</span>', 'url' => '/admin/orders/completion'),
            array('label' => 'Аналітика', 'url' => '/admin/orders/filtr'),
            array('label' => 'Переоцінка', 'url' => '/admin/orders/revaluation'),
        )); ?>
    </div>
</div>
<div class="span10">
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
    <br/>
    <?php
    foreach ($model as $results => $value) {
        foreach ($value as $keys => $key) {
            $user = Users::model()->findByPk($keys);
            echo date('d.m.Y', strtotime($results)) . '<span style="font-size:18px; font-weight: bold; margin-left:15px"><a href="/admin/users/update?id=' . $user->id . '">' . $user->organisation . '&nbsp;&nbsp;&nbsp;' . $user->organisation_status . '</a></span><span class="pull-right"><strong>' . $user->userCity->name . '&nbsp;&nbsp;&nbsp;' . $user->carrier . '&nbsp;&nbsp;&nbsp;' . '№: ' . $user->district . '</strong></span>';
            $this->widget('yiiwheels.widgets.grid.WhGridView', array(
                'type' => 'striped bordered',
                'fixedHeader' => true,
                'selectableRows' => 50,
                'dataProvider' => $key,
                'template' => "{items}",
                'rowCssClass' => array('setGreenColor', 'setFillColor', 'setRedColor'),
                'rowCssClassExpression' => '$data->send==0?$this->rowCssClass[1]:($data->quantity!=$data->received?$this->rowCssClass[2]:$this->rowCssClass[0])',
                'htmlOptions' => array('style' => 'width:150%;'),
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
                        'type' => 'raw',
                        'value' => function ($data) {
                            switch ($data->provider) {
                                case    'http://webcatalog.opoltrans.com.pl/':
                                    return $data->is_advance ? '<span style="font-style: italic; font-weight: bold">Ополь</span>' : 'Ополь';
                                    break;
                                case    'http://sklep.martextruck.pl/':
                                    return $data->is_advance ? '<span style="font-style: italic; font-weight: bold">Мартекс</span>' : 'Мартекс';
                                    break;
                                case    'http://www.intercars.com.pl/':
                                    return $data->is_advance ? '<span style="font-style: italic; font-weight: bold">Інтеркарс</span>' : 'Інтеркарс';
                                    break;
                                case    'http://sklep.skuba.com.pl':
                                    return $data->is_advance ? '<span style="font-style: italic; font-weight: bold">Скуба</span>' : 'Скуба';
                                    break;
                                case    'http://www.diesel-czesci.pl/':
                                    return $data->is_advance ? '<span style="font-style: italic; font-weight: bold">Дізель</span>' : 'Дізель';
                                    break;
                                case    'https://sklep.autos.com.pl/':
                                    return $data->is_advance ? '<span style="font-style: italic; font-weight: bold">Автос</span>' : 'Автос';
                                    break;
                            }
                        },
                        'htmlOptions' => array('style' => 'width:100px;'),
                    ),
                    'name' => array(
                        'name' => 'name',
                        'header' => 'Назва',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'width:300px; !important'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . $data->name . '</span>') : $data->name;
                        }
                    ),
                    array(
                        'name' => 'cod',
                        'header' => 'Номер запчастини',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'width:80px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . $data->cod . '</span>') : $data->cod;
                        }
                    ),
                    array(
                        'name' => 'manufacturer',
                        'header' => 'Виробник',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'width:70px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . $data->manufacturer . '</span>') : $data->manufacturer;
                        }
                    ),

                    array(
                        'name' => 'quantity',
                        'header' => 'Кількість',
                        'sortable' => true,
                        'type' => 'raw',
                        'footer' => Orders::model()->getUserSumByDateOrdered($keys, $results,1,0)['quantity'] + Orders::model()->getUserSumByDateOrdered($keys, $results,1,1)['quantity'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'htmlOptions' => array('style' => 'width:70px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . $data->quantity . '</span>') : $data->quantity;
                        }
                    ),
                    array(
                        'name' => 'price_in',
                        'header' => 'Ціна PLN',
                        'type' => 'raw',
                        'sortable' => true,
                        'htmlOptions' => array('style' => 'width:80px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->price_in, 2, ',', '') . '</span>') : number_format($data->price_in, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'price_in_sum',
                        'header' => 'Сума PLN',
                        'sortable' => true,
                        'type' => 'raw',
                        'footer' => Orders::model()->getUserSumByDateOrdered($keys, $results,1,0)['price_in_sum'] + Orders::model()->getUserSumByDateOrdered($keys, $results,1,1)['price_in_sum'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'htmlOptions' => array('style' => 'width:80px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->price_in_sum, 2, ',', '') . '</span>') : number_format($data->price_in_sum, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'vat',
                        'header' => 'VAT',
                        'sortable' => true,
                        'type' => 'raw',
                        'footer' => Orders::model()->getUserSumByDateOrdered($keys, $results, 1, 0)['vat'] + Orders::model()->getUserSumByDateOrdered($keys, $results, 1, 1)['vat'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->vat, 2, ',', '') . '</span>') : number_format($data->vat, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'work',
                        'header' => 'Робота',
                        'sortable' => true,
                        'type' => 'raw',
                        'footer' => Orders::model()->getUserSumByDateOrdered($keys, $results, 1, 0)['work'] +Orders::model()->getUserSumByDateOrdered($keys, $results, 1, 1)['work'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'htmlOptions' => array('style' => 'width:80px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->work, 2, ',', '') . '</span>') : number_format($data->work, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'summary',
                        'header' => 'Загально',
                        'sortable' => true,
                        'type' => 'raw',
                        'footer' => Orders::model()->getUserSumByDateOrdered($keys, $results, 1, 0)['summary'] + Orders::model()->getUserSumByDateOrdered($keys, $results, 1, 1)['summary'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'htmlOptions' => array('style' => 'width:80px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->summary, 2, ',', '') . '</span>') : number_format($data->summary, 2, ',', '');
                        }
                    ),
                    array(
                        'header' => 'Відгрузка',
                        'name' => 'send',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->send == 1 ? TbHtml::icon(TbHtml::ICON_OK) : '<a href="/admin/orders/setSend?id=' . $data->id . '" class="btn btn-primary" id="order" >Ok</a>';
                        },
                        'htmlOptions' => array('style' => 'text-align:center; width: 50px')
                    ),
                    array(
                        'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                        'name' => 'received',
                        'header' => 'К-ть',
                        'sortable' => true,
                        'editable' => array(
                            'url' => $this->createUrl('/admin/orders/editOrder'),
                            'placement' => 'left',
                            'inputclass' => 'span3',
                        ),
                        'htmlOptions' => array('style' => 'width:40px;'),
                    ),
                    array(
                        'header' => '',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<a href="/admin/orders/setNotSend?id=' . $data->id . '" class="btn btn-default" id="order" >Виправити</a>';
                        },
                        'htmlOptions' => array('style' => 'text-align:center;width:40px;'),
                        'visible' => Yii::app()->user->checkAccess('administrator')
                    ),
                ),
            ));
        }
    } ?>


</div>
<!--<script>-->
<!--	$.each($('tr'), function(){-->
<!--		if( $(this).children('td').children('.send_toggle').html() == '<i class="icon-ok-circle"></i>')-->
<!--			{-->
<!--				$(this).children('td').children('a').addClass('not-active');-->
<!--//						alert($(this).children('td').children('.send_toggle').html());-->
<!--			}-->
<!---->
<!--	});-->
<!---->
<!--</script>-->