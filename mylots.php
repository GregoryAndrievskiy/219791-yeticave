<?php

session_start();

require_once 'functions.php';

require_once 'mysql_helper.php';

require_once 'init.php';


$bets = [];

if (isset($_SESSION['user'])) {
	
	$user_id = (int)$_SESSION['user']['id'];

    $query = 'SELECT 
			lot.id, 
			lot.img_url, 
			lot.name, 
			bet.bet_date, 
			bet.cost, 
			lot.expire_date, 
			category.name AS category  
		FROM bet 
        JOIN user ON bet.user_id = user.id 
		JOIN lot ON bet.lot_id = lot.id 
		JOIN category ON lot.category_id = category.id 
		WHERE bet.user_id = ?;';

    $bets = select_data($con, $query, ['bet.user_id' => $user_id]);

} else {

    $bets = [];

};

$bets_data = [
	'bets' => $bets
];

$content = renderTemplate('templates/mylots.php', $bets_data );

$layout_data = [
    'title' => 'Мои ставки',
    'categories' => $select_data_categories,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>