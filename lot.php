<?php

require_once 'init.php';

$id = (int)$_GET['id'];

$session_user = '';

if(isset($_SESSION['user'])) {
	
	$session_user = $_SESSION['user']['id'];
}

$lotQuery = 'SELECT
	lot.id,
	name,
	start_price,
	img_url,
	expire_date,
	description,
	author_id,
	bet_step,
	category_id,
	IFNULL(MAX(bet.cost), lot.start_price) as bet_price,
	COUNT(bet.lot_id) as bets_number
FROM lot
LEFT JOIN bet ON bet.lot_id = lot.id
WHERE lot.id = ?
GROUP BY lot.id
ORDER BY lot.expire_date DESC;';

$selected_lot = select_data($con, $lotQuery, ['lot.id' => $id])[0];

$lot_category_id = (int)$selected_lot['category_id'];

$selected_lot_category = get_category_by_id($lot_category_id, $categories_list)[0];

$betsQuery = 'SELECT
    user.name as user_name,
    user.id as user_id,
    bet.cost as bet_cost,
    bet.bet_date
FROM bet
JOIN user ON user.id = bet.user_id
WHERE bet.lot_id = ?
ORDER BY bet.bet_date DESC';

$selected_bet = select_data($con, $betsQuery, ['bet.lot_id' => $id]);

if ($selected_lot) {
	
	$errors = [];
	$price = $selected_lot['start_price'];
	
	foreach ($selected_bet as $key => $value) {

		if($value['user_id'] === $session_user) {
		
			$errors[] = 'bet-done';
		
		}
		if(!empty($selected_bet[0]['bet_cost'])) {
			
			$price = $selected_bet[0]['bet_cost'];
			
		}
	}
	
	if (!empty($_POST['cost'])) {
		
		$bet = $_POST['cost'];

		if ($bet < ($price + $selected_lot['bet_step'])) {

			$errors[] = 'low-bet';

		} else {
			
			$now = date('Y-m-d H:i:s', strtotime('now'));
			$values = [
				'bet_date' => $now,
				'cost' => $_POST['cost'],
				'user_id' => $session_user,
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
		'categories' => $categories_list,
		'description' => $selected_lot['description'],
		'bets_number' => $selected_lot['bets_number'],
		'expire_date' => $selected_lot['expire_date'],
		'author_id' => $selected_lot['author_id'],
		'bet_step' => $selected_lot['bet_step'],
		'bets' => $selected_bet,
		'default_error_class' => 'form__item--invalid',
		'errors' => $errors
	];

	$content = renderTemplate('templates/lot.php', $lot_data);

	$layout_data = [
		'title' => $lot_data['name'],
		'categories' => $categories_list,
		'content' => $content
	];

	print(renderTemplate('templates/layout.php', $layout_data));

} else {

	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	print('404');

};
?>