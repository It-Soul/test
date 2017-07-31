<?php
/* @var $this OrdersController */
/* @var $model Orders */


$this->menu=array(
		array('label'=>'На головну', 'url'=>array('/admin/site/index')),
	array('label'=>'Список замовленнь', 'url'=>array('index')),
);
?>

<h1>Створити замовлення</h1><br>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>