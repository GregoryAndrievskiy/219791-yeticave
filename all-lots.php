<?php

session_start();

require_once 'functions.php';

require_once 'mysql_helper.php';

require_once 'init.php';

$page_item_count = 3;
$offset = 0;
$current_category = (int)$_GET['id'] ?? 1;
$current_category_page = (int)$_GET['page'] ?? 1;
$offset = ($current_category_page - 1) * $page_item_count;

$lotCountQuery = 'SELECT COUNT(*) as count FROM lot WHERE lot.category_id = ?;';

$lot_count = select_data($con, $lotCountQuery, ['lot.category_id' => $current_category])[0]['count'];

$categoryLotsQuery = 'SELECT 
	lot.id, 
	lot.name, 
	lot.start_price, 
	lot.img_url,
	category.name AS cat,
	lot.expire_date
FROM lot 
LEFT JOIN category ON category.id = lot.category_id 
WHERE lot.category_id = ?
ORDER BY expire_date ASC
LIMIT ? OFFSET ?';

$select_data_category_lots = select_data($con, $categoryLotsQuery, ['lot.category_id' => $current_category, $page_item_count, $offset]);

$pagination_data = pagination_data('all-lots.php?id='.$current_category.'&', $current_category_page, $page_item_count, $lot_count);

$pagination = renderTemplate('templates/pagination.php', $pagination_data);

$all_lots_data = [
	'lots' => $select_data_category_lots, 
	'categories' => $select_data_categories,
	'pagination' => $pagination
];

$content = renderTemplate('templates/all-lots.php', $all_lots_data );

$layout_data = [
    'title' => 'Главная',
    'categories' => $select_data_categories,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>