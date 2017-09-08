<?php

session_start();

require_once 'functions.php';


$lots = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '10999',
        'url' => 'img/lot-1.jpg'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '159999',
        'url' => 'img/lot-2.jpg'
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => '8000',
        'url' => 'img/lot-3.jpg'
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => '10999',
        'url' => 'img/lot-4.jpg'
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => '7500',
        'url' => 'img/lot-5.jpg'
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => '5400',
        'url' => 'img/lot-6.jpg'
    ]
];

$id = $_GET['id'];
$bets;

if ($lots[$id]) {
	
	$errors = [];
	$bet = $_POST['new-bet'];
	$price = $lots[$id]['price'];
	
	if (isset($_COOKIE['bets'])) {

        $bets = json_decode($_COOKIE['bets'], true);
        
        foreach ($bets as $bet_item) {

			if ($bet_item['id'] === $id) {

				$errors[] = 'bet-done';

			};
        };
    };
	
	if (!empty($bet)) {

		if ($bet < ($price + $_POST['step'])) {

			$errors[] = 'low-bet';

		} else {

			$expire_date = strtotime('tomorrow midnight');
			$price = $bet;
			$bets[] = [
				'id' => $id, 
				'name' => $lots[$id]['name'],
				'url' => $lots[$id]['url'],
				'category' => $lots[$id]['category'],
				'date' => strtotime('now'), 
				'price' => $price,
				'expire' => $expire_date
			];
			$errors[] = 'bet-done';
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