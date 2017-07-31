<?php
/* @var $this UsersController */
/* @var $model Users */

//$this->breadcrumbs=array(
//	'Users'=>array('index'),
//	'Manage',
//);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiWhGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="span5"><h1>
		Клієнти <?php echo CHtml::link('Зареєструвати нового користувача', '/admin/users/registerUser', array('class' => 'btn btn-warning')); ?></h1>
</div>
<div class="span7">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'regions' => $regions,
	'cities' => $cities
)); ?>
</div>

<div class="span12">
	<?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
		'fixedHeader' => true,
		'id' =>'users-grid',
		'type' => 'striped bordered',
		'dataProvider' => $model->search(),
		'filter' => $model,
		'responsiveTable' => true,
		'template' => "{items}",
		'selectableRows' => 50,
		'htmlOptions' => array('style' => 'color: black; width:107%'),
		'rowCssClass' => array('odd', 'setOrangeColor'),
		'rowCssClassExpression' =>'$data->status==0?$this->rowCssClass[1]:$this->rowCssClass[0]',
		'columns'=>array(

			array(
				'class' => 'CCheckBoxColumn',
			),
			'id',
			'organisation'=>array(
				'name' => 'organisation',
				'type' => 'raw',
				'value'=>function($data){
					return '<a href="/admin/users/update?id=' . $data->id . '">' . $data->organisation . '</a>';
				},
				'filter' => '',
				'htmlOptions' => array('style' => ' width:200px'),
			),
			'activity' =>array(
				'header' =>'Діяльність',
				'name' => 'reg_like',
				'type' => 'raw',
				'value' =>function($data){
					return '<a href="/admin/users/update?id='.$data->id.'">'.$data->reg_like.'</a>';
				},
				'filter'=>array('Магазин' => 'Магазин', 'Сервіс' => 'Сервіс', 'Перевізник' => 'Перевізник / власник ТЗ'),
			),

			'opole' =>array(
				'header' =>'Статус',
				'name' => 'opole',
				'type' => 'raw',
				'value' =>function($data){
					switch($data->opole){
						case 0 : return '<a href="/admin/users/update?id='.$data->id.'">Не задано</a>';break;
						case 1 : return '<a href="/admin/users/update?id='.$data->id.'">Дрібний</a>';break;
						case 2 : return '<a href="/admin/users/update?id='.$data->id.'">Середній</a>';break;
						case 3 : return '<a href="/admin/users/update?id='.$data->id.'">Великий</a>';break;
						case 4 : return '<a href="/admin/users/update?id='.$data->id.'">VIP</a>';break;
					}
				},
				'filter'=>array(0=>"Не задано",1=>"Дрібний", 2=>"Середній", 3=>"Великий", 4=>"VIP"),
				'htmlOptions' => array('style' => ' width:80px'),
			),
			'region' => array(
				'name' => 'region',
				'type' => 'raw',
				'value' => function($data){
					$region = new Region();
					$region = $region->getUserRegion($data->region);
					return '<a href="/admin/users/update?id='.$data->id.'">'.$region.'</a>';
				},
				'filter' => Region::model()->getAllRegions()
			),
			'city' => array(
				'name' => 'city',
				'type' => 'raw',
				'value' => function($data){
					$city = new City();
					$city = $city->getUserCity($data->city);
					return '<a href="/admin/users/update?id='.$data->id.'">'.$city.'</a>';
				},
				'filter' => City::model()->getAllCities()
			),
			'role'=>array(
				'name'=>'role',
				'type' => 'raw',
				'value'=>function($data){
					switch($data->role){
						case "user" : return '<a href="/admin/users/update?id='.$data->id.'">Користувач</a>'; break;
						case "manager" : return '<a href="/admin/users/update?id='.$data->id.'">Менеджер</a>'; break;
						case "courier" : return '<a href="/admin/users/update?id='.$data->id.'">Куратор</a>'; break;
						case "administrator" : return '<a href="/admin/users/update?id='.$data->id.'">Адміністратор</a>'; break;
						default : return '<a href="/admin/users/update?id='.$data->id.'">Заблокований</a>';
					}
				},
				'filter'=>array('user'=> 'Користувач','manager'=>"Менеджер",'courier'=>'Куратор','administrator'=>"Адміністратор"),
			),
			'user_rol'=>array(
				'name'=>'user_rol',
				'type' => 'raw',
				'value'=>function($data){
					switch($data->user_rol){
						case "1" : return '<a href="/admin/users/update?id='.$data->id.'">Продавець</a>'; break;
						case "2" : return '<a href="/admin/users/update?id='.$data->id.'">Покупець</a>'; break;
						default : return '<a href="/admin/users/update?id='.$data->id.'">Не задано</a>';
					}
				},
				'filter'=>array('1'=> 'Продавець','2'=>"Покупець"),
			),

			array(
				'name'=>'curator',
				'type' => 'raw',
				'value' => function($data){
					if($data->curator && $data->curator!=-1){
						return '<a href="/admin/users/update?id='.$data->id.'">Куратор '.$data->curator.'</a>';
					} else return '<a href="/admin/users/update?id='.$data->id.'">Не задано</a>';
				},
				'filter'=>array('1'=> 'Куратор 1', '2'=>"Куратор 2", '3'=> 'Куратор 3', '4'=>"Куратор 4", '5'=> 'Куратор 5'),
			),
			array(
				'name' => 'martecs',
				'type' => 'raw',
				'value' => function($data){
					if($data->martecs && $data->martecs!=-1){
						return '<a href="/admin/users/update?id='.$data->id.'">Менеджер '.$data->martecs.'</a>';
					} else return '<a href="/admin/users/update?id='.$data->id.'">Не задано</a>';
				},
				'filter'=>array('1'=> 'Менеджер 1', '2'=>"Менеджер 2", '3'=> 'Менеджер 3', '4'=>"Менеджер 4", '5'=> 'Менеджер 5', '6'=> 'Менеджер 6', '7'=>"Менеджер 7", '8'=> 'Менеджер 8', '9'=>"Менеджер 9", '10'=> 'Менеджер 10',
					'11'=> 'Менеджер 11', '12'=>"Менеджер 12", '13'=> 'Менеджер 13', '14'=>"Менеджер 14", '15'=> 'Менеджер 15', '16'=> 'Менеджер 16', '17'=>"Менеджер 17", '18'=> 'Менеджер 18', '19'=>"Менеджер 19",'20'=>"Менеджер 20",
					'21'=> 'Менеджер 21', '22'=>"Менеджер 22", '23'=> 'Менеджер 23', '24'=>"Менеджер 24", '25'=> 'Менеджер 25', '26'=> 'Менеджер 26', '27'=>"Менеджер 27", '28'=> 'Менеджер 28', '29'=>"Менеджер 29",'30'=>"Менеджер 30",
					'31'=> 'Менеджер 31', '32'=>"Менеджер 32", '33'=> 'Менеджер 33', '34'=>"Менеджер 34", '35'=> 'Менеджер 35', '36'=> 'Менеджер 36', '37'=>"Менеджер 37", '38'=> 'Менеджер 38', '39'=>"Менеджер 39",'40'=>"Менеджер 40",
					'41'=> 'Менеджер 41', '42'=>"Менеджер 42", '43'=> 'Менеджер 43', '44'=>"Менеджер 44", '45'=> 'Менеджер 45', '46'=> 'Менеджер 46', '47'=>"Менеджер 47", '48'=> 'Менеджер 48', '49'=>"Менеджер 49",'50'=>"Менеджер 50",
					'51'=> 'Менеджер 51', '52'=>"Менеджер 52", '53'=> 'Менеджер 53', '54'=>"Менеджер 54", '55'=> 'Менеджер 55', '56'=> 'Менеджер 56', '57'=>"Менеджер 57", '58'=> 'Менеджер 58', '59'=>"Менеджер 59"),
			),
	//		'username',
	//		'phone',
	//		'email',
			/*'password',*/

	//		'organisation',

	//		'city',
			'status'=>array(
				'name'=>'status',
				'type' => 'raw',
					'value'=>'($data->status==1)?"<p style=\"color: green\">Підтверджений</p>":(($data->status==0)?"<p style=\"color: red\">Не підтверджений</p>":"<p style=\"color: grey\">Заблокований</p>")',
					'filter'=>array(0=>"Не підтверджений",1=>"Підтверджений", 2=>"Заблокований"),
				'htmlOptions' => array('style' => ' width:110px'),
			),


		),
	)); ?>
	</div>
<script type="text/javascript" src="/js/maskedinput.js"></script>
<script>
	$("#Users_phone").mask('+38(999) 999 99 99');
</script>