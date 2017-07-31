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
<h1>Доопрацювання</h1>

<div class="span2">
    <div class="well" style="max-width: 340px; padding: 8px 0;">
        <?php echo TbHtml::navList(array(
            array('label' => 'Замовлення <span class="red">' . count(Orders::model()->findAllByAttributes(array('ordered' => 0, 'completion' => 0))) . '</span>', 'url' => '/admin/orders'),
            array('label' => 'Логістика <span class="red">' . count(Orders::model()->findAllByAttributes(array('ordered' => 1, 'send' => 0))) . '</span>', 'url' => '/admin/orders/logistic'),
            array('label' => 'Доопрацювання <span class="red">' . $notMatchLogistic . '</span>', 'url' => '/admin/orders/completion', 'active' => true),
            array('label' => 'Аналітика', 'url' => '/admin/orders/filtr'),
            array('label' => 'Переоцінка', 'url' => '/admin/orders/revaluation'),
        )); ?>
    </div>
</div>
<div class="span10">
    <br/>
    <?php
    foreach ($model as $results => $value) {
        foreach ($value as $keys => $key) {
            $user = Users::model()->findByPk($keys);
            echo date('d.m.Y', strtotime($results)) . '<span style="font-size:18px; font-weight: bold; margin-left:15px"><a href="/admin/users/update?id=' . $user->id . '">' . $user->organisation . '&nbsp;&nbsp;&nbsp;' . $user->organisation_status . '</a></span><span class="pull-right"><strong>' . $user->userCity->name . '&nbsp;&nbsp;&nbsp;' . $user->carrier . '&nbsp;&nbsp;&nbsp;' . '№: ' . $user->district . '</strong></span>';
            $this->widget('yiiwheels.widgets.grid.WhGridView', array(
                'type' => 'striped bordered',
                'fixedHeader' => true,
                'dataProvider' => $key,
                'template' => "{items}",
                'rowCssClass' => array('setGreenColor', 'setFillColor', ''),
                'rowCssClassExpression' => '$data->ordered==0?$this->rowCssClass[0]:($data->send==0?$this->rowCssClass[2]:$this->rowCssClass[1])',
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
                        'footer' => Orders::model()->getUserSumByDateFin($keys, $results,1)['quantity'],
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
                        'footer' => Orders::model()->getUserSumByDateFin($keys, $results,1)['price_in_sum'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'htmlOptions' => array('style' => 'width:80px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->price_in_sum, 2, ',', '') . '</span>') : number_format($data->price_in_sum, 2, ',', '');
                        }
                    ),

                    array(
                        'name' => 'manager',
                        'header' => 'Менеджер',
                        'sortable' => true,
                        'type' => 'raw',
                        'footer' => Orders::model()->getUserSumByDateFin($keys, $results,1)['manager'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'htmlOptions' => array('style' => 'width:80px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->manager, 2, ',', '') . '</span>') : number_format($data->manager, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'courier',
                        'header' => 'Куратор',
                        'sortable' => true,
                        'type' => 'raw',
                        'footer' => Orders::model()->getUserSumByDateFin($keys, $results,1)['courier'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'htmlOptions' => array('style' => 'width:80px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->courier, 2, ',', '') . '</span>') : number_format($data->courier, 2, ',', '');
                        }

                    ),
                    array(
                        'name' => 'admin',
                        'header' => 'Адмін',
                        'sortable' => true,
                        'type' => 'raw',
                        'footer' => Orders::model()->getUserSumByDateFin($keys, $results,1)['admin'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'htmlOptions' => array('style' => 'width:80px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->admin, 2, ',', '') . '</span>') : number_format($data->admin, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'course',
                        'header' => 'Курс',
                        'sortable' => true,
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'width:80px;'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->course, 2, ',', '') . '</span>') : number_format($data->course, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'price_out',
                        'header' => 'Ціна грн',
                        'sortable' => true,
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->price_out, 2, ',', '') . '</span>') : number_format($data->price_out, 2, ',', '');
                        }
                    ),
                    array(
                        'name' => 'price_out_sum',
                        'header' => 'Сума грн',
                        'sortable' => true,
                        'type' => 'raw',
                        'footer' => Orders::model()->getUserSumByDateFin($keys, $results,1)['price_out_sum'],
                        'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                        'value' => function ($data) {
                            return $data->is_advance ? ('<span style="font-style: italic; font-weight: bold">' . number_format($data->price_out_sum, 2, ',', '') . '</span>') : number_format($data->price_out_sum, 2, ',', '');
                        }
                    ),
                    array(
                        'header' => 'Заказ',
                        'name' => 'ordered',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->ordered == 1 ? TbHtml::icon(TbHtml::ICON_OK) : '<a href="/admin/orders/setOrdered?id=' . $data->id . '" class="btn btn-primary" id="order" >Ok</a>';
                        },
                        'htmlOptions' => array('style' => 'text-align:center')
                    ),
                    array(
                        'header' => '',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<a href="/admin/orders/update?id=' . $data->id . '" class="btn btn-default" id="order" >Редагувати</a>';
                        },
                        'htmlOptions' => array('style' => 'text-align:center'),
                        'visible' => Yii::app()->user->checkAccess('administrator')
                    ),
                ),
            ));
        }
    } ?>
</div>
