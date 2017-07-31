<?php
/* @var $this CabinetController */

$this->breadcrumbs=array(
	'Мій кабінет'=>array('/cabinet'),
	'Декларації/Відправки',
);
?>
<br>
<!--<div class="row span2">-->
<!--	--><?php //$this->renderPartial('_cabinetmenu'); ?>
<!--</div>-->
<?php
echo $count;
Yii::app()->getComponent('yiiwheels')->registerAssetJs('bootbox.min.js');
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	'type' => 'striped bordered',
	'fixedHeader'=>true,
	'dataProvider' => $declarations,
	'template' => "{items}",
	'columns'=>array(

		array(

			'header' => '№',
			'value' => '$row+1',

		),

		'date' => array(
			'name' => 'date',
			'value' => 'date("d.m.Y", strtotime($data->date))'
		),
		'courier',
		'declar_numb',
		'places_numb',
		'comment',

	),
)); ?>
