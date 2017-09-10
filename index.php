<?php

session_start();

require_once 'functions.php';

$tomorrow = strtotime('tomorrow midnight');
$time = timeRemaining($tomorrow);

$index_data = [
	'lot' => $lots, 
	'categorie' => $categories,
	'time' => $time 
];

$content = renderTemplate('templates/index.php', $index_data );

$layout_data = [
    'title' => 'Главная',
    'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>