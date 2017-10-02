<?php

$current_page = $_GET['page'] ?? 1;
	
$next_page = count($templateData['range']); 

if ($current_page < $next_page) { 

	$next_page = $current_page + 1; 

} 

$prev_page = 1; 

if ($current_page > $prev_page) { 

	$prev_page = $current_page - 1; 

} 
	
if (!empty($templateData['extra_params'])) {
	
	$params_string = '&'.http_build_query($templateData['extra_params']);
	
} else {
	
	$params_string = '';
}

?>
<? if (count($templateData['range']) > 1) : ?>
	<ul class="pagination-list">
		<li class="pagination-item pagination-item-prev"><a href='?page=<?=$prev_page;?><?=$params_string?>'>Назад</a></li>
		<? foreach ($templateData['range'] as $page) : ?>
			<li class="pagination-item <?= ($page == $current_page) ? 'pagination-item-active' : '' ;?> ">
				<a href="?page=<?=$page;?><?=$params_string?>"><?= $page; ?></a>
			</li>
		<? endforeach; ?>
		<li class="pagination-item pagination-item-next"><a href='?page=<?=$next_page;?><?=$params_string?>'>Вперед</a></li>
	</ul>
<? endif; ?>