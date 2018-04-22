<?php
	DEFINE('DB_USER', 'root');
	DEFINE('DB_PASSWORD', '');
	DEFINE('DB_HOST', 'localhost');
	DEFINE('DB_NAME', 'register');


	$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('could not connect to MySQL: ' . mysqli_connect_error());
	mysqli_set_charset($dbc, 'utf8');

?>