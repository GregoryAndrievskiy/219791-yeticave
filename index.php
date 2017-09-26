<?php
session_start();

require_once ('vendor/autoload.php');

require_once 'functions.php';

require_once 'mysql_helper.php';

require_once 'init.php';

$lot_count_sql = 'SELECT * FROM lot WHERE expire_date > NOW();';
$lot_count = count(select_data($con, $lot_count_sql));

$lots_per_page = 3;
$offset = get_offset($_GET['page'],$lots_per_page);

$lots_sql = 'SELECT 
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

$lots = select_data($con, $lots_sql, [$lots_per_page, $offset]);

$pagination = renderTemplate('templates/pagination.php', [
	'range' => get_pagination_range($lots_per_page,$lot_count),
]);

$content = renderTemplate('templates/index.php', [
	'lots' => $lots
]);

$layout_data = [
    'title' => 'Главная',
	'is_index' => true,
    'categories' => $select_data_categories,
	'pagination' => $pagination,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>