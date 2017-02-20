<?php

	require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

  Chronicle\Base::setup_connection([
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'make-it-all', 
    ]);