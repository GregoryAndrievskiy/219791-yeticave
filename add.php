<?php
require_once 'functions.php';
$new_add_lot = true;
$valid_list = [
	'lot-form' => true,
	'lot-name' => true,
	'lot-category' => true,
	'lot-message' => true,
	'lot-photo' => true,
	'lot-rate' => true,
	'lot-step' => true,
	'lot-date' => true
];
if (!empty($_POST)) {
	foreach ($_POST as $key => $value) {
		if(!$_POST[$key]) {
			$valid_list[$key] = false;
		} elseif ($key === 'lot-rate' || $key === 'lot-step') {
			if (!is_numeric($value)) $valid_list[$key] = false;
		} elseif ($key === 'lot-category') {
			if ($value === 'Выберите категорию') $valid_list[$key] = false;
		};
	};
	$file_info = finfo_open(FILEINFO_MIME_TYPE);
	$file_name = $_FILES['lot-photo']['tmp_name'];
	if ($file_name) {
		$file_type = finfo_file($file_info, $file_name);
		if ($file_type !== 'image/jpeg') $valid_list['lot-photo'] = false;
	} else {
		$valid_list['lot-photo'] = false;
	};
	$valid_counter = 0;
	foreach ($valid_list as $key => $value) { 
		if ($value) {
			$valid_counter++;
		}
	};
	if ($valid_counter === 8) {
		$file_name = $_POST['lot-date'] . $_POST['lot-rate'] . $_POST['lot-step'];
		$file_path = __DIR__ . '/img/';
		move_uploaded_file($_FILES['lot-photo']['tmp_name'], $file_path . $file_name);
		$file_url = 'img/' . $file_name;
		$form_data['price'] = $_POST['lot-rate'];
		$form_data['name'] = $_POST['lot-name'];
		$form_data['url'] = $file_url;
		$form_data['category'] = $_POST['lot-category'];
		$form_data['description'] = $_POST['lot-message'];
		$content = renderTemplate('templates/lot.php', $form_data);
		$new_lot_data = [
			'title' => $form_data['name'],
			'content' => $content
		];
		print(renderTemplate('templates/layout.php', $new_lot_data));
	} else {
		$valid_list['lot-form'] = false;
		$content = renderTemplate('templates/add.php', $valid_list);
		$layout_data = [
			'title' => 'Добавление лота',
			'content' => $content
		];
		print(renderTemplate('templates/layout.php', $layout_data));
	}
} else {
	$content = renderTemplate('templates/add.php', $valid_list);
	$layout_data = [
		'title' => 'Добавление лота',
		'content' => $content
	];
	print(renderTemplate('templates/layout.php', $layout_data));
}
?>