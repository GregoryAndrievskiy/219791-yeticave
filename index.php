<?php

session_start();

require_once 'functions.php';
require_once 'lot.php';

$index_data = [
	'lot' => $lots, 
	'categorie' => $categories,
	'time' => $lot_time_remaining
];

$content = renderTemplate('templates/index.php', $index_data );

$layout_data = [
    'title' => 'Главная',
    'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>