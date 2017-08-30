
<?php
    require_once 'functions.php';
    $index_data = [
		'lot' => $lots, 
		'categorie' => $categories,
		'time' => $lot_time_remaining
	];
    $content = renderTemplate('templates/index.php', $index_data );
    $layout_data = [
        'title' => 'Главная',
        'user' => 'Константин',
        'avatar' => 'img/user.jpg',
        'content' => $content
    ];
    print(renderTemplate('templates/layout.php', $layout_data));
		print($categories);
?>