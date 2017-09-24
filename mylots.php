<?php

session_start();

require_once 'functions.php';

require_once 'mysql_helper.php';

require_once 'init.php';


$bets = [];

if (isset($_SESSION['user'])) {

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
		WHERE bet.user_id = ' . $_SESSION['user']['id'] . ';';

    $bets = select_data($con, $query);

} else {

    $bets = [];

};

$bets_data = [
	'bets' => $bets, 
	'categories' => $select_data_categories,
];

$content = renderTemplate('templates/mylots.php', $bets_data );

$layout_data = [
    'title' => 'Мои ставки',
    'categories' => $select_data_categories,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>