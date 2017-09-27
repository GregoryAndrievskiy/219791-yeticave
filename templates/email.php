<?php

	$name = $templateData['name'];
	$lot_url = $templateData['lot_url'];
	$lot_name = $templateData['lot_name'];
	$my_lots = 'mylots.php';

?>
<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?=  $name; ?></p>
<p>Ваша ставка для лота <a href="<?=  $lot_url; ?>"><?=  $lot_name; ?></a> победила.</p>
<p>Перейдите по ссылке <a href="<?=  $my_lots; ?>">мои ставки</a>,
    чтобы связаться с автором объявления</p>

<small>Интернет Аукцион "YetiCave"</small>
