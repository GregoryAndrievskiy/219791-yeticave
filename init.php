<?php

require_once('functions.php');

$con = mysqli_connect('localhost', 'root', '', 'yeticave');

$select_data_categories = select_data($con, 'SELECT id, name, cssClass FROM category ORDER by category.id');

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

?>