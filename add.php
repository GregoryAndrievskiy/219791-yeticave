<?php
require_once 'functions.php';
$valid_list = [
	'form' => true,
	'name' => true,
	'category' => true,
	'message' => true,
	'photo' => true,
	'rate' => true,
	'step' => true,
	'date' => true
];
if (isset($_POST)) {
	if (!$_POST['lot-name']) $valid_list['name'] = false;
	if ($_POST['lot-category'] === 'Выберите категорию') $valid_list['category'] = false;
	if (!$_POST['lot-message']) $valid_list['message'] = false;
	if (!isset($_FILES['lot-photo'])) {
			$valid_list['photo'] = false;
		$file_info = finfo_open(FILEINFO_MIME_TYPE);
		$file_name = $_FILES['lot-photo']['tmp_name'];
		$file_type = finfo_file($file_info, $file_name);
		if ($file_type !== 'image/jpeg') $valid_list['photo'] = false;
	};
	if (!$_POST['lot-rate'] || !is_numeric($_POST['lot-rate'])) $valid_list['rate'] = false;
	if (!$_POST['lot-step'] || !is_numeric($_POST['lot-step'])) $valid_list['step'] = false;
	if (!$_POST['lot-date']) $valid_list['date'] = false;
};
$valid_counter = 0;
foreach ($valid_list as $key => $value) { 
	if ($value === true) {
		$valid_counter++;
	}
};
if ($valid_counter === 8) {
	$file_name = $_POST['lot-date'] . $_POST['lot-rate'] . $_POST['lot-step'];
	$file_path = __DIR__ . '/img/';
	move_uploaded_file($_FILES['lot-photo']['tmp_name'], $file_path . $file_name);
	$form_data['price'] = $_POST['lot-rate'];
	$form_data['name'] = $_POST['lot-name'];
	$form_data['url'] = 'img/' . $file_name;
	$form_data['category'] = $_POST['lot-category'];
	$form_data['description'] = $_POST['lot-message'];
	$content = renderTemplate('templates/lot.php', $form_data);
	$new_lot_data = [
		'title' => $form_data['name'],
        'content' => $content
	];
	print(renderTemplate('templates/layout.php', $new_lot_data));
} else {
	$valid_list['form'] = false;
	$content = renderTemplate('templates/add.php', $valid_list);
	$layout_data = [
		'title' => 'Добавление лота',
		'content' => $content
	];
	print(renderTemplate('templates/layout.php', $layout_data));
}
?>