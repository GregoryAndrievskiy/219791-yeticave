<?php

session_start();

require_once 'functions.php';
  
  if (isset($_COOKIE['bets'])) {

    $bets = json_decode($_COOKIE['bets'], true);

  }
  else {

    $bets = [];

  };

$bets_data = [
	'bets' => $bets, 
	'categories' => $categories,
];

$content = renderTemplate('templates/mylots.php', $bets_data );

$layout_data = [
    'title' => 'Мои ставки',
    'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>