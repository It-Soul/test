<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias('excel', 'uploads/excel');
Yii::setPathOfAlias('photos', 'uploads/photos');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'timeZone' =>'Europe/Kiev',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'LogistiscParts',
		'language' => 'uk',
	// preloading 'log' component
	'preload'=>array('log'),
	'aliases' => array(
		//'curlall'=>realpath(__DIR__ . '/../extensions/CurlAll.php'),
		'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'),
        'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'),
    ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.vendors.*',
		'application.components.*',
		'bootstrap.helpers.*',
		'bootstrap.widgets.*',
        'ext.editable.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>false,
			'generatorPaths' => array('bootstrap.gii'),
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),

	),


	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
				'class' => 'WebUser',
		),


		// uncomment the following to enable URLs in path-format

			'authManager' => array(
				// Будем использовать свой менеджер авторизации
					'class' => 'PhpAuthManager',

				// Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
					'defaultRoles' => array('guest'),
			),
		'bootstrap' => array(
			'class' => 'bootstrap.components.TbApi',
		),
		'yiiwheels' => array(
			'class' => 'yiiwheels.YiiWheels',
		),
		'urlManager'=>array(
				'showScriptName' => false,
			'urlFormat'=>'path',
				'appendParams'=>false,
			'rules'=>array(
//				'index'=>'site/index',
//                'admin'=>'admin/site',
//				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
//				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),


		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'info.lcparts@gmail.com',
	),
);
