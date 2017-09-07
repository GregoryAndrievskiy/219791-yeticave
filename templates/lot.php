<?php

// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];
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
$lot_price = $templateData['price'];
$lot_name = $templateData['name'];
$lot_url = $templateData['url'];
$lot_category = $templateData['category'];
$lot_step = $templateData['step'];
if ($templateData['description']) {
	$lot_description = $templateData['description'];
	} else {
	$lot_description = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег
					мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот
					снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом
					кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется,
					просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.';
};
?>
<main>
	<nav class="nav">
	<ul class="nav__list container">
	  <li class="nav__item">
		<a href="all-lots.html">Доски и лыжи</a>
	  </li>
	  <li class="nav__item">
		<a href="all-lots.html">Крепления</a>
	  </li>
	  <li class="nav__item">
		<a href="all-lots.html">Ботинки</a>
	  </li>
	  <li class="nav__item">
		<a href="all-lots.html">Одежда</a>
	  </li>
	  <li class="nav__item">
		<a href="all-lots.html">Инструменты</a>
	  </li>
	  <li class="nav__item">
		<a href="all-lots.html">Разное</a>
	  </li>
	</ul>
	</nav>
	<section class="lot-item container">
		<h2><?=htmlspecialchars($lot_name);?></h2>
		<div class="lot-item__content">
			<div class="lot-item__left">
				<div class="lot-item__image">
					<img src="<?=$lot_url;?>" width="730" height="548" alt="<?=htmlspecialchars($lot_category);?>">
				</div>
				<p class="lot-item__category">Категория: <span><?=htmlspecialchars($lot_category);?></span></p>
				<p class="lot-item__description"><?=htmlspecialchars($lot_description);?></p>
			</div>
			<div class="lot-item__right">
				<div class="lot-item__state">
					<div class="lot-item__timer timer">
						10:54:12
					</div>
					<div class="lot-item__cost-state">
						<div class="lot-item__rate">
							<span class="lot-item__amount">Текущая цена</span>
							<span class="lot-item__cost"><?=$lot_price;?></span>
						</div>
						<div class="lot-item__min-cost">
							Мин. ставка <span><?=$lot_price + $lot_step;?> р</span>
						</div>
					</div>
					<form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
						<p class="lot-item__form-item">
							<label for="cost">Ваша ставка</label>
							<input id="cost" type="number" name="cost" placeholder="12 000">
						</p>
						<button type="submit" class="button">Сделать ставку</button>
					</form>
				</div>
				<div class="history">
					<h3>История ставок (<span>4</span>)</h3>
					<!-- заполните эту таблицу данными из массива $bets-->
					<table class="history__list">
						<?php foreach ($bets as $key => $value) : ?>
							<tr class="history__item">
								<td class="history__name"><?=$value['name'];?></td>
								<td class="history__price"><?=$value['price'];?> р</td>
								<td class="history__time"><?=$timeManagement($value['ts']);?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
		</div>
	</section>
</main>