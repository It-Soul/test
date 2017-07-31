<?php
/* @var $this UsersController */
/* @var $model Users */

//$this->breadcrumbs=array(
//	'Users'=>array('index'),
//	$model->id,
//);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Створити', 'url'=>array('create')),
	array('label'=>'Змінити', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Видалити', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Впевнені,що хочете видалити користувача?')),
	//array('label'=>'На головну', 'url'=>array('admin')),
);
?>

<h1>Перегляд<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'email',
		'password',
		'organisation',
		'username',
		'phone',
		'city',
		'hashcode',
		'status',
		'role',
		'reg_like',
		'default_note',
		'opole',
		'martecs',
		'ip',
		'region',
		'district',
		'date',
	),
)); ?>
