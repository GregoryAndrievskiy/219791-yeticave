<section class="lot-item container">
	<h2><?=htmlspecialchars($templateData['name']);?></h2>
	<div class="lot-item__content">
		<div class="lot-item__left">
			<div class="lot-item__image">
				<img src="<?=$templateData['url'];?>" width="730" height="548" alt="<?=htmlspecialchars($templateData['category']);?>">
			</div>
			<p class="lot-item__category">Категория: <span><?=htmlspecialchars($templateData['category']);?></span></p>
			<p class="lot-item__description"><?=htmlspecialchars($templateData['description']);?></p>
		</div>
		<div class="lot-item__right">
			<div class="lot-item__state">
				<div class="lot-item__timer timer">
					<?=(strtotime($templateData['expire_date']) > strtotime('now')) ? htmlspecialchars(timeRemaining($templateData['expire_date'])) : 'завершен';?>
				</div>
				<div class="lot-item__cost-state">
					<div class="lot-item__rate">
						<span class="lot-item__amount">Текущая цена</span>
						<span class="lot-item__cost"><?=$templateData['price'];?></span>
					</div>
					<div class="lot-item__min-cost">
						Мин. ставка <span><?=$templateData['price'] + $templateData['bet_step'];?> р</span>
					</div>
				</div>
				<? if(isset($_SESSION['user']) && !in_array('bet-done', $templateData['errors']) && ($_SESSION['user']['id'] !== $templateData['author_id'])): ?>
					<form class="lot-item__form" action="lot.php?id=<?=$_GET['id'];?>" method="post">
						<p class="lot-item__form-item <?=in_array('low-bet', $templateData['errors']) ? $templateData['default_error_class'] : ''?>">
							<label for="cost">Ваша ставка</label>
							<input id="cost" type="number" name="cost" placeholder="<?=$templateData['price'] + $templateData['bet_step'];?>" value="<?=$_POST['cost'];?>">
						</p>
						<button type="submit" class="button">Сделать ставку</button>
					</form>
				<? endif; ?>
			</div>
			<div class="history">
				<h3>История ставок (<span><?=!empty($templateData['bets_number']) ? $templateData['bets_number'] : '0'?></span>)</h3>
				<table class="history__list">
					<?php foreach ($templateData['bets'] as $key => $value) : ?>
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