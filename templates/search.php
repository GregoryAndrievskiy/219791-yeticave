<div class="container">
	<section class="lots">
		<h2>Результаты поиска по запросу «<span><?=$_GET['search'];?></span>»</h2>
		<ul class="lots__list">
		<? foreach ($templateData['lots'] as $key => $value) : ?>
			<li class="lots__item lot">
				<div class="lot__image">
					<img src="<?=$value['img_url']; ?>" width="350" height="260" alt="<?=htmlspecialchars($value['lot_name']); ?>">
				</div>
				<div class="lot__info">
					<span class="lot__category"><?=htmlspecialchars($value['category_name']); ?></span>
					<h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$value['id']?>"><?=htmlspecialchars($value['lot_name']); ?></a></h3>
					<div class="lot__state">
						<div class="lot__rate">
							<span class="lot__amount">Стартовая цена</span>
							<span class="lot__cost"><?=htmlspecialchars($value['start_price']); ?><b class="rub">р</b></span>
						</div>
						<div class="lot__timer timer">
							<?=(strtotime($value['expire_date']) > strtotime('now')) ? htmlspecialchars(timeRemaining($value['expire_date'])) : print('завершен');?>
						</div>
					</div>
				</div>
			</li>
		<? endforeach; ?>
		</ul>
	</section>
	<?=$templateData['pagination'] ? print($templateData['pagination']) : ''; ?>
</div>