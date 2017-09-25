<?php

	$lot = $templateData['lots'];
	$categories = $templateData['categories'];
	$pages = $templateData['pages'];
	$page_count = $templateData['page_count'];
	$current_page = $templateData['current_page'];

?>
<main class="container">
	<section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
			<? foreach ($categories as $key => $value) : ?>
				<li class="promo__item <?=htmlspecialchars($value['cssClass']); ?>">
					<a class="promo__link" href="all-lots.php?<?= $value['id']; ?>"><?=htmlspecialchars($value['name']); ?></a>
				</li>
			<? endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
            <select class="lots__select">
				<option value='0'>Все категории</option>
				<? foreach ($categories as $key => $value) : ?>
					<option value="<?=$value['id'];?>"><?=htmlspecialchars($value['name']); ?></option>
				<? endforeach; ?>
            </select>
        </div>
        <ul class="lots__list">
		<? foreach ($lot as $key => $value) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$value['img_url']; ?>" width="350" height="260" alt="Сноуборд">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=htmlspecialchars($value['cat']); ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$value[id]?>"><?=htmlspecialchars($value['name']); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=htmlspecialchars($value['start_price']); ?><b class="rub">р</b></span>
                        </div>
                        <div class="lot__timer timer">
                            <?=htmlspecialchars(timeRemaining($value['expire_date']));?>
						</div>
                    </div>
                </div>
            </li>
		<? endforeach; ?>
        </ul>
    </section>
	<? if ($page_count > 1) : ?>
		<ul class="pagination-list">
			<li class="pagination-item pagination-item-prev"><a>Назад</a></li>
			<? foreach ($pages as $key) : ?>
			<li class="pagination-item <?= ($key == $current_page) ? 'pagination-item-active' : '' ;?> ">
				<a href="index.php?page=<?= $key; ?>"><?= $key; ?></a>
			</li>
			<? endforeach; ?>
			<li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
		</ul>
	<? endif; ?>
</main>