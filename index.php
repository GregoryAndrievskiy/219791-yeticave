<?php

session_start();

require_once 'functions.php';

require_once 'mysql_helper.php';

require_once 'init.php';

$tomorrow = strtotime('tomorrow midnight');
$time = timeRemaining($tomorrow);

$select_data_lates_lots = select_data($con, 'SELECT 
	lot.id, 
	lot.name, 
	lot.start_price, 
	lot.img_url,
	category.name AS cat,
	lot.expire_date
FROM lot 
LEFT JOIN category ON category.id = lot.category_id 
WHERE expire_date > NOW() 
ORDER BY lot.id ASC');

$index_data = [
	'lot' => $select_data_lates_lots, 
	'categories' => $select_data_categories,
	'time' => $time 
];

$content = renderTemplate('templates/index.php', $index_data );

$layout_data = [
    'title' => 'Главная',
    'categories' => $select_data_categories,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>