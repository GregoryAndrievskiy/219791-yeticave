<?php

	$range = $templateData['range'];
	$extra_params = $templateData['extra_params'];
	$current_page = $_GET['page'] ?? 1;
	
	$next_page;
	if ($current_page < count($range)) {
		
		$next_page = $current_page + 1;
		
	} else {
		
		$next_page = count($range);
		
	};

	$prev_page;
	
	if ($current_page > 1) {
		
		$prev_page = $current_page - 1;
		
	} else {
		
		$prev_page = 1;
		
	};
	
if (!empty($extra_params)) {
	
	$params_string = '&'.http_build_query($extra_params);
	
} else {
	
	$params_string = '';
}

?>
<? if (count($range) > 1) : ?>
	<ul class="pagination-list">
		<li class="pagination-item pagination-item-prev"><a href='?page=<?=$prev_page;?><?=$params_string?>'>Назад</a></li>
		<? foreach ($range as $page) : ?>
			<li class="pagination-item <?= ($page == $current_page) ? 'pagination-item-active' : '' ;?> ">
				<a href="?page=<?=$page;?><?=$params_string?>"><?= $page; ?></a>
			</li>
		<? endforeach; ?>
		<li class="pagination-item pagination-item-next"><a href='?page=<?=$next_page;?><?=$params_string?>'>Вперед</a></li>
	</ul>
<? endif; ?>