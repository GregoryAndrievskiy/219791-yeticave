<?php
require_once 'functions.php';
$valid_list = [
	'lot-name' => true,
	'lot-category' => true,
	'lot-message' => true,
	'lot-photo' => true,
	'lot-rate' => true,
	'lot-step' => true,
	'lot-date' => true
];
$error_list = [];
if (!empty($_POST)) {
	foreach ($valid_list as $key => $value) {
		if(!$_POST[$key]) {
			if ($key !== 'lot-photo') $error_list[] = $key;
		} elseif ($key === 'lot-rate' || $key === 'lot-step') {
			if (!is_numeric($_POST[$key])) $error_list[] = $key;
		} elseif ($key === 'lot-category') {
			if ($_POST[$key] === 'Выберите категорию') $error_list[] = $key;
		}; 
		if ($key === 'lot-photo') {
			$file_info = finfo_open(FILEINFO_MIME_TYPE);
			$file_name = $_FILES[$key]['tmp_name'];
			if ($file_name) {
				$valid_img_types = ['image/jpeg','image/png'];
				$file_type = finfo_file($file_info, $file_name);
				if (!in_array($file_type, $valid_img_types)) $error_list[] = $key;
			} else {
				$error_list[] = $key;
			};
		}; 
	};
	if (empty($error_list)) {
		$file_name = $_POST['lot-date'] . $_POST['lot-rate'] . $_POST['lot-step'];
		$file_path = __DIR__ . '/img/';
		move_uploaded_file($_FILES['lot-photo']['tmp_name'], $file_path . $file_name);
		$file_url = 'img/' . $file_name;
		$form_data = [
			'price' => $_POST['lot-rate'],
			'name' => $_POST['lot-name'],
			'url' => $file_url,
			'step' => $_POST['lot-step'],
			'category' => $_POST['lot-category'],
			'description' => $_POST['lot-message'],
		];
		$content = renderTemplate('templates/lot.php', $form_data);
		$layout_data = [
			'title' => $form_data['name'],
			'content' => $content
		];
	} else {
		$form_data = [
			'errors' => $error_list,
			'categories' => $categories
		];
		$content = renderTemplate('templates/add.php', $form_data);
		$layout_data = [
			'title' => 'Добавление лота',
			'content' => $content
		];
	}
} else {
	$form_data = [
		'errors' => $error_list,
		'categories' => $categories
	];
	$content = renderTemplate('templates/add.php', $form_data);
	$layout_data = [
		'title' => 'Добавление лота',
		'content' => $content
	];
}
print(renderTemplate('templates/layout.php', $layout_data));
?>