<?php

require_once 'init.php';

$lot_count = 0;

$lots_per_page = 3;

$offset = get_offset($_GET['page'],$lots_per_page);

$search = [];

$search_lot = [];

if (isset($_GET['search'])) {
	
    $search = $_GET['search'];
	
    $search = mysqli_real_escape_string($con, $search );
	
	$searchQuery = 'SELECT
		* FROM lot 
		JOIN category ON category_id = category.id 
		WHERE lot.name LIKE ? OR description LIKE ?';
	
    $search_lot = select_data($con, $searchQuery, [$search, $search]);

	$lot_count = count($search_lot);
};


$pagination = renderTemplate('templates/pagination.php', [
	'range' => get_pagination_range($lots_per_page,$lot_count),
]);

$content = renderTemplate('templates/search.php', [
	'pagination' => $pagination,
	'lots' => $search_lot
]);

$layout_data = [
    'title' => 'Результаты поиска',
    'categories' =>$categories_list,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>