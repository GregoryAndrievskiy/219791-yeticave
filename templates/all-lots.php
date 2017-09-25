﻿<?php
	$id = (int)$_GET['id'];
	$lot = $templateData['lots'];
	$categories = $templateData['categories'];
	$pagination = $templateData['pagination'];

?>
<main>
	<nav class="nav">
		<ul class="nav__list container">
			<? foreach ($categories as $key => $value) : ?>
				<li class="nav__item <?= ($key == $id - 1) ? 'nav__item--current' : '' ;?>">
					<a href="all-lots.php?id=<?= $value['id']; ?>&page=1"><?=$value['name'];?></a>
				</li>
			<? endforeach ?>
		</ul>
	</nav>
  <div class="container">
    <section class="lots">
      <h2>Все лоты в категории <span>«<?=$categories[$id - 1]['name'];?>»</span></h2>
      <ul class="lots__list">
		<? foreach ($lot as $key => $value) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$value['img_url']; ?>" width="350" height="260" alt="<?=htmlspecialchars($value['cat']); ?>">
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
	<?php print($pagination); ?>
  </div>
</main>