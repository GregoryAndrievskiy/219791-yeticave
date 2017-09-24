<?php

session_start();

require_once 'functions.php';

require_once 'mysql_helper.php';

require_once 'init.php';

$id = $_GET['id'];

$lotQuery = 'SELECT
	lot.id,
	name,
	start_price,
	img_url,
	expire_date,
	description,
	bet_step,
	category_id,
	IFNULL(MAX(bet.cost), lot.start_price) as bet_price,
	COUNT(bet.lot_id) as bets_number
FROM lot
LEFT JOIN bet ON bet.lot_id = lot.id
WHERE lot.id = ' . $id . '
GROUP BY lot.id
ORDER BY lot.expire_date DESC;';

$selected_lot = select_data($con, $lotQuery)[0];

$lot_category_id = $selected_lot['category_id'];

$lotCatQuery = 'SELECT
	name,
	cssClass
FROM category
WHERE category.id = ' . $lot_category_id . ';';

$selected_lot_category = select_data($con, $lotCatQuery)[0];

$betsQuery = 'SELECT
    user.name as user_name,
    user.id as user_id,
    bet.cost as bet_cost,
    bet.bet_date as bet_date
FROM bet
JOIN user ON user.id = bet.user_id
WHERE bet.lot_id = ' . $id . '
ORDER BY bet.bet_date DESC';

$selected_bet = select_data($con, $betsQuery);

if ($selected_lot) {
	
	$errors = [];
	$bet = $_POST['cost'];
	$price = $selected_lot['start_price'];
	
	foreach ($selected_bet as $key => $value) {

		if($value['user_id'] === $_SESSION['user']['id']) $errors[] = 'bet-done';
		
		if(!empty($selected_bet[0]['bet_cost'])) {
			
			$price = $selected_bet[0]['bet_cost'];
			
		}
	}
	
	if (!empty($bet)) {

		if ($bet < ($price + $selected_lot['bets_step'])) {

			$errors[] = 'low-bet';

		} else {
			
			$now = date('Y-m-d H:i:s', strtotime('now'));
			$values = [
				'bet_date' => $now,
				'cost' => $_POST['cost'],
				'user_id' => $_SESSION['user']['id'],
				'lot_id' => $id
			];
			insert_data($con, 'bet', $values);
			header("Location: /mylots.php");

		};
	};

	$lot_data = [
		'name' => $selected_lot['name'],
		'category' => $selected_lot_category['name'],
		'price' => $price,
		'url' => $selected_lot['img_url'],
		'categories' => $select_data_categories,
		'description' => $selected_lot['description'],
		'bets_number' => $selected_lot['bets_number'],
		'expire_date' => $selected_lot['expire_date'],
		'step' => $selected_lot['bets_step'],
		'bets' => $selected_bet,
		'errors' => $errors
	];

	$content = renderTemplate('templates/lot.php', $lot_data);

	$layout_data = [
		'title' => $lot_data['name'],
		'categories' => $select_data_categories,
		'content' => $content
	];

	print(renderTemplate('templates/layout.php', $layout_data));

} else {

	if($_GET['id'] != null) {

		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		print('404');

	};
};
//print(count($_SESSION['user']));


foreach ($_SESSION['user'] as $key => $value) {
	print($key);
}
?>