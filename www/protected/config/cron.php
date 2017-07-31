<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Cron',

	// preloading 'log' component
	'preload'=>array('log'),

	'import'=>array(
		'application.components.*',
		'application.models.*',
		'application.vendors.*',
	),

	// application components
	'components'=>array(

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'logFile'=>'cron.log',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CFileLogRoute',
					'logFile'=>'cron_trace.log',
					'levels'=>'trace',
				),
			),
		),

	),
);
