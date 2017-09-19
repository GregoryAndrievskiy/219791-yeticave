<?php

require_once('functions.php');

$con = mysqli_connect('localhost', 'root', '', 'yeticave');

if($con == false) {
		
	$error = mysqli_connect_error();
	
	$error_data = [
		'error' => $error
	];

	$content = renderTemplate('templates/error.php', $error_data);
	
	$layout_data = [
		'title' => 'Ошибка',
		'content' => $content
	];
	
	print(renderTemplate('templates/layout.php', $layout_data));
	
	exit();
}

//insert_data($con, 'user', ['email' => 'zzz@xxx.ru', 'name' => 'bbb777']);

?>