<?php

require_once 'functions.php';

$categories = $templateData['categories'];
$bets = $templateData['bets'];

?>
<main>
	<nav class="nav">
	<ul class="nav__list container">
		<? foreach ($categories as $key => $value) : ?>
			<li class="nav__item">
				<a href="all-lots.html"><?=$value;?></a>
			</li>
		<? endforeach ?>
	</ul>
	</nav>
	<section class="rates container">
		<h2>Мои ставки</h2>
		<table class="rates__list">
			<? foreach ($bets as $key => $value) : ?>
				<tr class="rates__item">
					<td class="rates__info">
						<div class="rates__img"><img src="<?=$value['url'];?>" width="54" height="40" alt="Сноуборд"></div>
						<h3 class="rates__title"><a href="lot.php?id=<?=$value['id'];?>"><?=htmlspecialchars($value['name']);?></a></h3>
					</td>
					<td class="rates__category"><?=htmlspecialchars($value['category']);?></td>
					<td class="rates__timer"><div class="timer timer--finishing"><?=htmlspecialchars(timeRemaining($value['expire']));?></div></td>
					<td class="rates__price"><?=$value['price'];?> р</td>
					<td class="rates__time"><?=htmlspecialchars(timeManagement($value['date']));?></td>
				</tr>
			<? endforeach ?>
		</table>
  </section>
</main>