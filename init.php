<?php

session_start();

date_default_timezone_set('Europe/Moscow');

require_once 'functions.php';

require_once 'vendor/autoload.php';

$con = mysqli_connect('localhost', 'root', '', 'yeticave');

if($con == false) {
		
	$error = mysqli_connect_error();
	
	$error_data = [
		'error' => $error
	];

	print(renderTemplate('templates/error.php', $error_data));
	
	exit();
}

$categories_list = select_data($con, 'SELECT id, name, cssClass FROM category ORDER by category.id');

?>