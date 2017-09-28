<?php

require_once 'init.php';


$bets = [];

if (isset($_SESSION['user'])) {
	
	$user_id = (int)$_SESSION['user']['id'];

    $query = 'SELECT 
		lot.id, 
		lot.name, 
		lot.img_url, 
		lot.expire_date, 
		lot.winner_id, 
		bet.cost, 
		bet.bet_date, 
		category.name AS category, 
		user.contacts 
	FROM bet 
	INNER JOIN lot ON bet.lot_id = lot.id
	INNER JOIN user ON lot.author_id = user.id
	INNER JOIN category ON lot.category_id = category.id
	WHERE bet.cost IN (SELECT MAX(cost) FROM bet WHERE user_id= ? GROUP BY lot_id)';

    $bets = select_data($con, $query, ['bet.user_id' => $user_id]);

}

$bets_data = [
	'bets' => $bets
];

$content = renderTemplate('templates/mylots.php', $bets_data );

$layout_data = [
    'title' => 'Мои ставки',
    'categories' => $categories_list,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>