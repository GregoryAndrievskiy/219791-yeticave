<?php

	$lot = $templateData['lot'];
	$categories = $templateData['categories'];

?>
<main class="container">
	<section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
			<? foreach ($categories as $key => $value) : ?>
				<li class="promo__item <?=htmlspecialchars($value['cssClass']); ?>">
					<a class="promo__link" href="all-lots.html"><?=htmlspecialchars($value['name']); ?></a>
				</li>
			<? endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
            <select class="lots__select">
				<? foreach ($categories as $key => $value) : ?>
					<option><?=htmlspecialchars($value['name']); ?></option>
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
</main>