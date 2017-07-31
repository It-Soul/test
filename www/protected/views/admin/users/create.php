<?php
/* @var $this UsersController */
/* @var $model Users */

//$this->breadcrumbs=array(
//	'Users'=>array('index'),
//	'Create',
//);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	//array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Створити користувача</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>