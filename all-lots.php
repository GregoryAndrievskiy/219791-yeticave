<?php

session_start();

require_once 'functions.php';

require_once 'mysql_helper.php';

require_once 'init.php';

$page_item_count = 3;
$page_count = 0;
$offset = 0;
$current_page = $_GET['page'] ?? 1;

$lotCountQuery = 'SELECT COUNT(*) as count FROM lot;';

$lot_count = select_data($con, $lotCountQuery)[0]['count'];
$page_count = ceil($lot_count / $page_item_count);
$offset = ($current_page - 1) * $page_item_count;
$pages = range(1, $page_count);

$latestLotsQuery = 'SELECT 
	lot.id, 
	lot.name, 
	lot.start_price, 
	lot.img_url,
	category.name AS cat,
	lot.expire_date
FROM lot 
LEFT JOIN category ON category.id = lot.category_id 
WHERE expire_date > NOW() 
ORDER BY expire_date ASC
LIMIT ? OFFSET ?';

$select_data_lates_lots = select_data($con, $latestLotsQuery, [$page_item_count, $offset]);

$index_data = [
	'lots' => $select_data_lates_lots, 
	'categories' => $select_data_categories,
	'pages' => $pages,
	'page_count' => $page_count,
	'current_page' => $current_page
];

$content = renderTemplate('templates/index.php', $index_data );

$layout_data = [
    'title' => 'Главная',
    'categories' => $select_data_categories,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>