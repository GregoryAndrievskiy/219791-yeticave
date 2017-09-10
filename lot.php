<?php

session_start();

require_once 'functions.php';

$id = $_GET['id'];
$bets;

if ($lots[$id]) {
	
	$errors = [];
	$bet = $_POST['cost'];
	$price = $lots[$id]['price'];
	
	if (isset($_COOKIE['bets'])) {

        $bets = json_decode($_COOKIE['bets'], true);
		
		if (array_key_exists($id, $bets)) $errors[] = 'bet-done';

    };
	
	if (!empty($bet)) {

		if ($bet < ($price + $_POST['step'])) {

			$errors[] = 'low-bet';

		} else {

			$expire_date = strtotime('tomorrow midnight');
			$price = $bet;
			$bets[$id] = [
				'id' => $id, 
				'name' => $lots[$id]['name'],
				'url' => $lots[$id]['url'],
				'category' => $lots[$id]['category'],
				'date' => strtotime('now'), 
				'price' => $price,
				'expire' => $expire_date
			];

			setcookie('bets', json_encode($bets), $expire_date, '/');
			header("Location: /mylots.php");

		};
	};

	$lot_data = [
		'name' => $lots[$id]['name'],
		'category' => $lots[$id]['category'],
		'price' => $price,
		'url' => $lots[$id]['url'],
		'categories' => $categories,
		'bets' => $old_bets,
		'errors' => $errors
	];

	$content = renderTemplate('templates/lot.php', $lot_data);

	$layout_data = [
		'title' => $lot_data['name'],
        'content' => $content
	];

	print(renderTemplate('templates/layout.php', $layout_data));

} else {

	if($_GET['id'] != null) {

		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		print('404');

	};
};
?>