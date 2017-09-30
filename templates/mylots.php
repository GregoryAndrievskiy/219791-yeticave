<section class="rates container">
	<h2>Мои ставки</h2>
	<table class="rates__list">
		<? foreach ($templateData['bets'] as $key => $value) : ?>
			<tr class="rates__item <?=
				!(strtotime($value['expire_date']) > strtotime('now')) ? 
				(($value['winner_id'] == $templateData['id']) ? 
				'rates__item--win':'rates__item--end') :''; 
			?>">
				<td class="rates__info">
					<div class="rates__img"><img src="<?=$value['img_url'];?>" width="54" height="40" alt="Сноуборд"></div>
					<div>
						<h3 class="rates__title"><a href="lot.php?id=<?=$value['id'];?>"><?=htmlspecialchars($value['name']);?></a></h3>
						<p><?=($value['winner_id'] === $templateData['id']) ? $value['contacts']:'';?></p>
					</div>
				</td>
				<td class="rates__category"><?=htmlspecialchars($value['category']);?></td>
				<td class="rates__timer">
					<div class="timer <?=
						!(strtotime($value['expire_date']) > strtotime('now')) ? 
						(($value['winner_id'] == $templateData['id']) ? 
						'timer--win':'rates__item--end') :'timer--finishing'; 
					?>">
					<?=(strtotime($value['expire_date']) > strtotime('now')) ? htmlspecialchars(timeRemaining($value['expire_date'])) : (($value['winner_id'] === $templateData['id']) ? 'Ставка выиграла' : 'Торги окончены');?>
					</div>
				</td>
				<td class="rates__price"><?=$value['cost'];?> р</td>
				<td class="rates__time"><?=htmlspecialchars(timeManagement($value['bet_date']));?></td>
			</tr>
		<? endforeach ?>
	</table>
</section>
