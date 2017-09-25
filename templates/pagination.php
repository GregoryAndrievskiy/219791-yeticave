<?php

require_once 'functions.php';

$type = $templateData['type'];
$pages = $templateData['pages'];
$page_count = $templateData['page_count'];
$current_page = $templateData['current_page'];


?>
<? if ($page_count > 1) : ?>
	<ul class="pagination-list">
		<li class="pagination-item pagination-item-prev"><a>Назад</a></li>
		<? foreach ($pages as $key) : ?>
		<li class="pagination-item <?= ($key == $current_page) ? 'pagination-item-active' : '' ;?> ">
			<a href="<?= $type; ?>page=<?= $key; ?>"><?= $key; ?></a>
		</li>
		<? endforeach; ?>
		<li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
	</ul>
<? endif; ?>