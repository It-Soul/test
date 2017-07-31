<?php
/* @var $this OrdersController */
/* @var $model Orders */


//$this->menu=array(
//	array('label'=>'На головну', 'url'=>array('/admin/site/index')),
//	array('label'=>'Створити замовлення', 'url'=>array('create')),
//);

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

<?php //$this->widget('yiiwheels.widgets.grid.WhGridView', array(
////	'fixedHeader' => true,
////	'headerOffset' => 40,
//	'type' => 'striped bordered',
//	'dataProvider' => $model,
////	'responsiveTable' => true,
//	'template' => "{items}",
//	'columns'=>array(
//		'id',
//		'user_id',
//		'name',
//		'cod',
//		'status',
//		'image',
//		'price_in_sum',
//		'user_name',
//
//		array(
//			'class'=>'CButtonColumn',
//		),
//	),
//)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'orders-grid',
	'dataProvider'=>$model,
//	'responsiveTable' => true,
	'template' => "{items}",
//	'filter'=>$model,
	'columns'=>array(
		array(

			'header' => '№',
			'value' => '$row+1',

		),
		'provider',
		'name',
		'cod',
		'quantity',
		'price_in' => array(
			'header' => 'Ціна PLN',
			'value' => '$data->price_in'
		),
		'price_in_sum' => array(
			'header' => 'Сума PLN',
			'value' => '$data->price_in_sum'
		),
		array(
			'header' => 'Курс ОЕ',
			'value' => function($model){
				$echange_rate = new ExchangeRates();
				$echange_rate = $echange_rate->getExchangeRates();
				return $echange_rate['zloty'];
			}
		),
		array(
			'header' => 'Ком. курс',
			'value' => function($model){
				$echange_rate = new ExchangeRates();
				$echange_rate = $echange_rate->getExchangeRates();
				return $echange_rate['zloty']+$echange_rate['zloty_repair'];
			}
		),
		array(
			'header' => 'VAT',
			'value' => function($model){
				$coef = new Coefficients();
				$coef = $coef->getUserCoefficient($model->user_id, $model->provider);
				$sum = $model->price_in_sum*$coef['vat'];
				$result = $sum - $model->price_in_sum;

				return $result;
			}
		),
		array(
			'header' => 'Логіст. PLN',
			'value' => function($model){
				$coef = new Coefficients();
				$coef = $coef->getUserCoefficient($model->user_id, $model->provider);
				return $model->price_in_sum * $coef['logistic'];
			}
		),
		array(
			'header' => 'Логіст. PLN',
			'value' => function($model){
				$coef = new Coefficients();
				$coef = $coef->getUserCoefficient($model->user_id, $model->provider);
				return ($model->price_in_sum * $coef['logistic'])-$model->price_in_sum;
			}
		),
		array(
			'header' => 'Менедж',
			'value' => function($model){
				$coef = new Coefficients();
				$coef = $coef->getUserCoefficient($model->user_id, $model->provider);
				return $coef['manager_coef'];
			}
		),
		array(
			'header' => 'Курат',
			'value' => function($model){
				$coef = new Coefficients();
				$coef = $coef->getUserCoefficient($model->user_id, $model->provider);
				return $coef['curator_coef'];
			}
		),
		array(
			'header' => 'Адмін',
			'value' => function($model){
				$coef = new Coefficients();
				$coef = $coef->getUserCoefficient($model->user_id, $model->provider);
				return $coef['admin_coef'];
			}
		),
		array(
			'header' => 'Курс',
			'value' => function($model){
				$coef = new Coefficients();
				$coef = $coef->getUserCoefficient($model->user_id, $model->provider);
				return '--';
			}
		),
		'price_out',
		'price_out_sum',
		array(
			'header' => 'Філіал',
			'value' => function($model){
				return '--';
			}
		),
		array(
			'header' => 'ЦТ склад',
			'value' => function($model){
				return '--';
			}
		),
		array(
			'header' => 'Інші',
			'value' => function($model){
				return '--';
			}
		),
		array(
			'header' => 'Заказ',
			'type' => 'raw',
			'value' => function($model){
				if($model->ordered==1){
					$result = '<p style="color: green">Так</p>';
				} else $result = '<p style="color: red">Ні</p>';
				return $result;
			}
		),
		array(
			'header' => 'Відгрузка',
			'type' => 'raw',
			'value' => function($model){
				if($model->send==1){
					$result = '<p style="color: green">Так</p>';
				} else $result = '<p style="color: red">Ні</p>';
				return $result;
			}
		),
//		'user_id',

//
//		'status',
//		'image',
//        'price_in_sum',
//		'user_name',

		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
