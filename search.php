<?php

require_once 'init.php';

$lot_count = 0;

$lots_per_page = 9;

$offset = 0; 

if (!empty($_GET['page'])) { 

	$offset = get_offset($_GET['page'], $lots_per_page); 
} 

$search = [];

$search_lot = [];

if (isset($_GET['search'])) {
	
    $search = $_GET['search'];
	
    $search = mysqli_real_escape_string($con, $search );
	
	$searchQuery = 'SELECT
			lot.id,
			lot.name AS lot_name,
			lot.expire_date,
			lot.img_url,
			lot.start_price,
			category.name AS category_name
		FROM lot 
		JOIN category ON category_id = category.id 
		WHERE lot.name LIKE ? OR description LIKE ?
		LIMIT ? OFFSET ?';
	
    $search_lot = select_data($con, $searchQuery, ['%'. $search .'%', '%'. $search .'%', $lots_per_page, $offset]);
	
	$searchQueryCount = 'SELECT
		COUNT(*) as count
		FROM lot 
		JOIN category ON category_id = category.id 
		WHERE lot.name LIKE ? OR description LIKE ?';
	
	$search_lot_count = select_data($con, $searchQueryCount, ['%'. $search .'%', '%'. $search .'%'])[0]['count'];
	
	$lot_count = $search_lot_count;
};

$pagination = renderTemplate('templates/pagination.php', [
	'range' => get_pagination_range($lots_per_page, $lot_count),
	'extra_params' => [
		'search' => $_GET['search']
	]
]);

$content = renderTemplate('templates/search.php', [
	'lots' => $search_lot
]);

$layout_data = [
    'title' => 'Результаты поиска',
    'categories' =>$categories_list,
	'pagination' => $pagination,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>