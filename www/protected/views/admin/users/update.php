<?php

 if(Yii::app()->user->hasFlash('success_2')): ?>
</br>
<?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success_2')); ?>
<?php else: ?>
<?php endif; ?>
<?php
$this->menu=array(
	array('label'=>'Список ', 'url'=>array('index')),
	array('label'=>'Створити користувача', 'url'=>array('create')),
//	array('label'=>'Коефіцієнти', 'url'=>array('/admin/coefficients', 'id'=>$model->id)),
	array('label'=>'На головну', 'url'=>array('site/index')),
);
?>

<!--<h1>Зміна користувача --><?php //echo $model->id; ?><!--</h1>-->
<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'regions' => $regions,
    'countries' => $countries,
	'cities' => $cities,
	'activity' => $activity,
	'orders' => $orders,
	'coefficients' => $coefficients,
	'count' => $count,
	'lastOrder' => $lastOrder,
	'managers' => $managers,
	'arrears' =>$arrears,
	'lastpayment' =>$lastpayment
)); ?>