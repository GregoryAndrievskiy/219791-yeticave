<?php

session_start();

require_once ('vendor/autoload.php');

require_once 'functions.php';

require_once 'mysql_helper.php';

require_once 'init.php';

$valid_list = ['reg-email', 'password', 'name', 'message'];
$error_list = [];
$default_avatar = true;

if (!empty($_POST)) {

	foreach ($valid_list as $key => $value) {

		if(!$_POST[$value]) {
			
			if ($value !== 'reg-email') $error_list[] = $value;

		} elseif ($value === 'reg-email') {
			
			$result = filter_var($_POST[$value], FILTER_VALIDATE_EMAIL);
			
			if (!$result) {
				
                $error_list[] = $value;
				
            } else {
				
				$query = 'SELECT * FROM user WHERE email = ?';

                $query_result = select_data($con, $query, ['email' => $value]);
				
                if (count($query_result) != 0) {
					
                    $error_list[] = $value;
					
                }
            }
		}
	};
	
	$file_info = finfo_open(FILEINFO_MIME_TYPE);
	$file_name = $_FILES['img_url']['tmp_name'];
	
	if ($file_name) {

		$valid_img_types = ['image/jpeg','image/png'];
		$file_type = finfo_file($file_info, $file_name);
		$default_avatar = false;

		if (!in_array($file_type, $valid_img_types)) {
			
			$error_list[] = 'img_url';

		}
	}
	
	if (count($error_list) == 0) {
		
		$file_url = 'img/avatar.jpeg';
		
		if (!$default_avatar) {
			
			$prefix = 'userAvatar';
			$file_name = uniqid($prefix);
			$file_path = __DIR__ . '/img/';
			move_uploaded_file($_FILES['img_url']['tmp_name'], $file_path . $file_name);
			$file_url = 'img/' . $file_name;
		}

        $now = date('Y-m-d H:i:s', strtotime('now'));
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $values = [
            'registration_date' => $now,
            'email' => $_POST['reg-email'],
            'name' => $_POST['name'],
            'password' => $password_hash,
            'avatar_url' => $file_url,
            'contacts' => $_POST['message']
        ];

        insert_data($con, 'user', $values);
		
		header('Location: /login.php');
        
	}
}

$sign_up_data = [
	'errors' => $error_list,
	'categories' => $select_data_categories
];

$content = renderTemplate('templates/sign-up.php', $sign_up_data);

$layout_data = [
	'title' => 'Регистрация',
	'categories' => $select_data_categories,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>