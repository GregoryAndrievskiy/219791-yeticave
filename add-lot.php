<?php
require_once 'functions.php';
$valid_list = [
	'form' => true,
	'name' => true,
	'category' => true,
	'message' => true,
	'photo' => true,
	'rate' => true,
	'step' => true,
	'date' => true
];
$content = renderTemplate('templates/add.php', $valid_list);
$layout_data = [
	'title' => 'Добавление лота',
	'content' => $content
];
$layout_data = [
    'title' => 'Добавление лота',
    'content' => $content
];
print(renderTemplate('templates/layout.php', $layout_data));
?>