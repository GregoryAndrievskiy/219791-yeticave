<?php

session_start();

require_once 'functions.php';

$valid_list = ['lot-name', 'lot-category', 'lot-message', 'lot-rate', 'lot-step', 'lot-date'];
$error_list = [];

if (isset($_SESSION['user'])) {

	if (!empty($_POST)) {

		foreach ($valid_list as $key => $value) {

			if(!$_POST[$value]) {

				if ($value !== 'lot-category') $error_list[] = $value;

			} elseif ($value === 'lot-rate' || $value === 'lot-step') {

				if (!is_numeric($_POST[$value])) $error_list[] = $value;

			} elseif ($value === 'lot-category') {

				if (!array_key_exists($_POST[$value],$categories)) $error_list[] = $value;

			} elseif ($value === 'lot-date') {

				if ($_POST[$value] !== date('d.m.Y',strtotime($_POST[$value]))) $error_list[] = $value;

			}; 
		};

		$file_info = finfo_open(FILEINFO_MIME_TYPE);
		$file_name = $_FILES['lot-photo']['tmp_name'];

		if ($file_name) {

			$valid_img_types = ['image/jpeg','image/png'];
			$file_type = finfo_file($file_info, $file_name);

			if (!in_array($file_type, $valid_img_types)) $error_list[] = 'lot-photo';

		} else {

			$error_list[] = 'lot-photo';

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
				'category' => $categories[$_POST['lot-category']],
				'description' => $_POST['lot-message'],
				'categories' => $categories
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

} else {

    header($_SERVER["SERVER_PROTOCOL"]." 403 Forbidden");
	print('403');

};
?>