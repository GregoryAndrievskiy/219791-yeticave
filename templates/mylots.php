<?php

$timeManagement = function ($timeStamp) {

	$now = time();
	$passedTime = $now - $timeStamp;
	$hours = floor($passedTime / 3600);
	$time;
	if ($hours >= 24) {

		$time = date("d.m.y в H:i", $timeStamp);

	} elseif ($hours >= 1) {

		$time = $hours . ' часов назад';

	} else {

		$time = floor(($passedTime % 3600) / 60) . ' минут назад';

	}
	return $time;
};

$timeRemaining = function ($expire) {

	$remainingTime = $expire - time();
	$hours = floor($remainingTime / 3600);
	$minutes =  floor(($remainingTime % 3600) / 60);
	return sprintf('%02d:%02d',$hours,$minutes);
};

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
					<td class="rates__category"><?=htmlspecialchars($bet_category);?></td>
					<td class="rates__timer"><div class="timer timer--finishing"><?=htmlspecialchars($timeRemaining($value['expire']));?></div></td>
					<td class="rates__price"><?=$value['price'];?> р</td>
					<td class="rates__time"><?=htmlspecialchars($timeManagement($value['date']));?></td>
				</tr>
			<? endforeach ?>
		</table>
  </section>
</main>