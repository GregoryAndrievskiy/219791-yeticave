<?php

require_once 'functions.php';

$bets = $templateData['bets'];

?>
<section class="rates container">
	<h2>Мои ставки</h2>
	<table class="rates__list">
		<? foreach ($bets as $key => $value) : ?>
			<tr class="rates__item">
				<td class="rates__info">
					<div class="rates__img"><img src="<?=$value['img_url'];?>" width="54" height="40" alt="Сноуборд"></div>
					<h3 class="rates__title"><a href="lot.php?id=<?=$value['id'];?>"><?=htmlspecialchars($value['name']);?></a></h3>
				</td>
				<td class="rates__category"><?=htmlspecialchars($value['category']);?></td>
				<td class="rates__timer"><div class="timer timer--finishing"><?=(strtotime($value['expire_date']) > strtotime('now')) ? htmlspecialchars(timeRemaining($value['expire_date'])) : print('завершен');?></div></td>
				<td class="rates__price"><?=$value['cost'];?> р</td>
				<td class="rates__time"><?=htmlspecialchars(timeManagement($value['bet_date']));?></td>
			</tr>
		<? endforeach ?>
	</table>
</section>
