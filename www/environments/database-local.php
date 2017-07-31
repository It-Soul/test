<?php

// This is the database connection configuration.
return array(
//	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
    // uncomment the following lines to use a MySQL database

    'connectionString' => 'mysql:host=your_host;dbname=your_db_name',
    'emulatePrepare' => true,
    'username' => 'your_user_name',
    'password' => 'your_password',
    'charset' => 'utf8',

);