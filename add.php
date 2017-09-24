<?php

session_start();

require_once 'functions.php';

require_once 'mysql_helper.php';

require_once 'init.php';

$valid_list = ['lot-name', 'lot-category', 'lot-message', 'lot-rate', 'lot-step', 'lot-date'];
$error_list = [];

if (isset($_SESSION['user'])) {

	if (!empty($_POST)) {

		foreach ($valid_list as $key => $value) {

			if(!$_POST[$value]) {

				if ($value !== 'lot-category') {
					
					$error_list[] = $value;
					
				}

			} elseif ($value === 'lot-rate' || $value === 'lot-step') {

				if (!is_numeric($_POST[$value])) {
					
					$error_list[] = $value;
					
				}

			} elseif ($value === 'lot-category') {

				if (!array_key_exists(($_POST[$value] - 1),$select_data_categories)) {
					$error_list[] = $value;
				}

			} elseif ($value === 'lot-date') {

				if ($_POST[$value] !== date('d.m.Y',strtotime($_POST[$value]))) {
					$error_list[] = $value;
				}
			}; 
		};

		$file_info = finfo_open(FILEINFO_MIME_TYPE);
		$file_name = $_FILES['lot-photo']['tmp_name'];

		if ($file_name) {

			$valid_img_types = ['image/jpeg','image/png'];
			$file_type = finfo_file($file_info, $file_name);

			if (!in_array($file_type, $valid_img_types)) {
				
				$error_list[] = 'lot-photo';
			}

		} else {

			$error_list[] = 'lot-photo';

		};
		if (empty($error_list)) {

			$file_name = $_POST['lot-date'] . $_POST['lot-rate'] . $_POST['lot-step'];
			$file_path = __DIR__ . '/img/';

			move_uploaded_file($_FILES['lot-photo']['tmp_name'], $file_path . $file_name);

			$file_url = 'img/' . $file_name;
			
			$now = date('Y-m-d H:i:s', strtotime('now'));

			$lot_data = [
				'start_price' => $_POST['lot-rate'],
				'name' => $_POST['lot-name'],
				'img_url' => $file_url,
				'bet_step' => $_POST['lot-step'],
				'category_id' => $_POST['lot-category'],
				'author_id' => $_SESSION['user']['id'],
				'description' => $_POST['lot-message'],
				'expire_date' => $_POST['lot-date'],
				'create_date' => $now
			];

			insert_data($con, 'lot', $lot_data);
			
			$lotQuery = 'SELECT 
				id
			FROM lot
			WHERE author_id = ' . $_SESSION['user']['id'] . '
			ORDER BY create_date DESC';

			$my_last_lot_id = select_data($con, $lotQuery)[0]['id'];

            header('Location: /lot.php?id=' . $my_last_lot_id);

		} else {

			$form_data = [
				'errors' => $error_list,
				'categories' => $select_data_categories
			];

			$content = renderTemplate('templates/add.php', $form_data);

			$layout_data = [
				'title' => 'Добавление лота',
				'categories' => $select_data_categories,
				'content' => $content
			];
		}
	} else {

		$form_data = [
			'errors' => $error_list,
			'categories' => $select_data_categories
		];

		$content = renderTemplate('templates/add.php', $form_data);

		$layout_data = [
			'title' => 'Добавление лота',
			'categories' => $select_data_categories,
			'content' => $content
		];
	}

	print(renderTemplate('templates/layout.php', $layout_data));

} else {

    header($_SERVER["SERVER_PROTOCOL"]." 403 Forbidden");
	print('403');

};
?>