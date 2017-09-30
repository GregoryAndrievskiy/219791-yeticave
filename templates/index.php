<section class="lots">
	<div class="lots__header">
		<h2>Открытые лоты</h2>
		<select class="lots__select">
			<option value='0'>Все категории</option>
			<? foreach ($templateData['categories'] as $key => $value) : ?>
				<option value="<?=$value['id'];?>"><?=htmlspecialchars($value['name']); ?></option>
			<? endforeach; ?>
		</select>
	</div>
	<ul class="lots__list">
	<? foreach ($templateData['lots'] as $key => $value) : ?>
		<li class="lots__item lot">
			<div class="lot__image">
				<img src="<?=$value['img_url']; ?>" width="350" height="260" alt="<?=htmlspecialchars($value['category']); ?>">
			</div>
			<div class="lot__info">
				<span class="lot__category"><?=htmlspecialchars($value['category']); ?></span>
				<h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$value['id']?>"><?=htmlspecialchars($value['name']); ?></a></h3>
				<div class="lot__state">
					<div class="lot__rate">
						<span class="lot__amount">Стартовая цена</span>
						<span class="lot__cost"><?=htmlspecialchars($value['start_price']); ?><b class="rub">р</b></span>
					</div>
					<div class="lot__timer timer">
						<?=(strtotime($value['expire_date']) > strtotime('now')) ? htmlspecialchars(timeRemaining($value['expire_date'])) : 'завершен';?>
					</div>
				</div>
			</div>
		</li>
	<? endforeach; ?>
	</ul>
</section>