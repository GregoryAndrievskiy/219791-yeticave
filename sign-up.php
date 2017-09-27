<?php

require_once 'init.php';

$valid_list = ['reg-email', 'password', 'name', 'message'];
$error_list = [];

if (!empty($_POST)) {

	$error_list = get_empty_required($_POST,$valid_list);

	if (!in_array('reg-email',$error_list) ) {
		
		if (!filter_var($_POST['reg-email'], FILTER_VALIDATE_EMAIL) || search_user_by_email($con,$_POST['reg-email'])) {
			
			$error_list[] = 'reg-email';	
		}
	}
	
	$file = $_FILES['img_url']['tmp_name'];
	
	if (!empty($file) && check_filetype($file)) {

		$errors_list[] = 'img_url';
	}
	
	if (empty($error_list)) {
		
		$file_url = '';
		
		if (!empty($file)) {

			$file_url = save_file($file, 'userAvatar');
		}

        $values = [
            'registration_date' =>  date('Y-m-d H:i:s', strtotime('now')),
            'email' => $_POST['reg-email'],
            'name' => $_POST['name'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'avatar_url' => $file_url,
            'contacts' => $_POST['message']
        ];

        insert_data($con, 'user', $values);
		
		header('Location: /login.php?reg=ok');
        
	}
}

$sign_up_data = [
	'errors' => $error_list
];

$content = renderTemplate('templates/sign-up.php', $sign_up_data);

$layout_data = [
	'title' => 'Регистрация',
	'categories' => $categories_list,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>