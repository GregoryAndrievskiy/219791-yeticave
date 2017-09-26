<?php

require_once 'init.php';

$category_id = (int)$_GET['category'];

if ($category_id) {

	$lot_count_sql = 'SELECT COUNT(*) as count FROM lot WHERE lot.category_id = ?;';
	$lot_count = select_data($con, $lot_count_sql, ['lot.category_id' => $category_id])[0]['count'];

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
	WHERE lot.category_id = ?
	ORDER BY expire_date ASC
	LIMIT ? OFFSET ?';

	$lots = select_data($con, $lots_sql, ['lot.category_id' => $category_id, $lots_per_page, $offset]);

	$pagination = renderTemplate('templates/pagination.php', [
		'range' => get_pagination_range($lots_per_page,$lot_count),
		'extra_params' => [
			'category' => $category_id
		]
	]);

	$content = renderTemplate('templates/all-lots.php', [
		'lots' => $lots, 
		'categories' => $categories_list
	]);

	$layout_data = [
	    'title' => 'Главная',
	    'categories' => $categories_list,
	    'pagination' => $pagination,
		'content' => $content
	];

	print(renderTemplate('templates/layout.php', $layout_data));

} else {
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	print('404');
}


?>