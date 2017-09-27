<?php

require_once 'init.php';

$valid_list = ['lot-name', 'lot-category', 'lot-message', 'lot-rate', 'lot-step', 'lot-date'];
$error_list = [];

if (isset($_SESSION['user'])) {

	if (!empty($_POST)) {

		$error_list = get_empty_required($_POST, $valid_list);

		if (!in_array('lot-rate', $error_list)) {
			
			if (!is_numeric($_POST['lot-rate']) || $_POST['lot-rate'] < 0) {
				
				$error_list[] = 'lot-rate';
			}
		}

		if (!in_array('lot-step',$error_list)) {
			
			if (!is_numeric($_POST['lot-step']) || (int)$_POST['lot-step'] < 0) {
				
				$error_list[] = 'lot-step';
			}
		}

		if (!in_array('lot-category', $error_list) && !get_category_by_id($_POST['lot-category'], $categories_list)) {
			
			$error_list[] = 'lot-category';
		}

		if (!in_array('lot-date', $error_list)) {
			
			if ($_POST['lot-date'] !== date('d.m.Y',strtotime($_POST['lot-date'])) || !((strtotime($_POST['lot-date']) - strtotime('now')) >= 86400)) {
					
				$error_list[] = 'lot-date';
			}
		}
		
		$file = $_FILES['lot-photo']['tmp_name'];
		
		if (empty($file) || !check_filetype($file)) {
			
			$error_list[] = 'lot-photo';
		}

		if (empty($error_list)) {
			

			$lot_data = [
				'start_price' => $_POST['lot-rate'],
				'name' => $_POST['lot-name'],
				'img_url' => save_file($file, 'lot_img'),
				'bet_step' => (int)$_POST['lot-step'],
				'category_id' => $_POST['lot-category'],
				'author_id' => $_SESSION['user']['id'],
				'description' => $_POST['lot-message'],
				'expire_date' => date("Y-m-d", strtotime($_POST['lot-date'])),
				'create_date' => date('Y-m-d H:i:s', strtotime('now'))
			];

			$lot_id = insert_data($con, 'lot', $lot_data);

            header('Location: /lot.php?id=' . $lot_id);
		}
	}

	$form_data = [
		'errors' => $error_list,
		'categories' => $categories_list
	];

	$content = renderTemplate('templates/add.php', $form_data);

	$layout_data = [
		'title' => 'Добавление лота',
		'categories' => $categories_list,
		'content' => $content
	];

	print(renderTemplate('templates/layout.php', $layout_data));
	print(count($error_list));
	print(save_file($file, 'lot_img'));
	print($error_list[0]);
	
} else {

    header($_SERVER["SERVER_PROTOCOL"]." 403 Forbidden");
	print('403');

};


?>