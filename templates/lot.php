<?php

require_once 'functions.php';

$id = (int)$_GET['id'];

$default_error_class = 'form__item--invalid';

$bets = $templateData['bets'];
$bets_number = $templateData['bets_number'];
$lot_price = $templateData['price'];
$lot_name = $templateData['name'];
$lot_url = $templateData['url'];
$lot_category = $templateData['category'];
$lot_description = $templateData['description'];
$lot_step = $templateData['bet_step'];
$lot_author = $templateData['author_id'];
$lot_date = $templateData['expire_date'];
$errors = $templateData['errors'];

if(!empty($bets)) {

	$lot_price = $bets[0]['bet_cost'];

}
?>
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
					<?=htmlspecialchars(timeRemaining($lot_date));?>
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
				<? if(isset($_SESSION['user']) && !in_array('bet-done',$errors) && ($_SESSION['user']['id'] !== $lot_author)): ?>
					<form class="lot-item__form" action="lot.php?id=<?=$id;?>" method="post">
						<p class="lot-item__form-item <?=in_array('low-bet',$errors) ? $default_error_class : ''?>">
							<label for="cost">Ваша ставка</label>
							<input id="cost" type="number" name="cost" placeholder="<?=$lot_price + $lot_step;?>" value="<?=$_POST['cost'];?>">
						</p>
						<button type="submit" class="button">Сделать ставку</button>
					</form>
				<? endif; ?>
			</div>
			<div class="history">
				<h3>История ставок (<span><?=!empty($bets_number) ? $bets_number : '0'?></span>)</h3>
				<table class="history__list">
					<?php foreach ($bets as $key => $value) : ?>
						<tr class="history__item">
							<td class="history__name"><?=$value['user_name'];?></td>
							<td class="history__price"><?=$value['bet_cost'];?> р</td>
							<td class="history__time"><?=timeManagement($value['bet_date']);?></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</section>