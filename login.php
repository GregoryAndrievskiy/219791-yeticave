<?php

require_once 'init.php';

$valid_list = ['login-email','login-password'];
$error_list = [];

if (!empty($_POST)) {
	
	$error_list = get_empty_required($_POST, $valid_list);

	if (empty($error_list)) {
		
		$user = search_user_by_email($con,$_POST['login-email']);

		if (!$user) {
			
			$error_list[] = 'login-email';
		}
		if ($user && password_verify($_POST['login-password'], $user['password'])) {
			
			$_SESSION['user'] = $user;
			header("Location: /index.php");
			
		} else {
			
			$error_list[] = 'login-password';

		}
	}
}

$login_data = [
	'errors' => $error_list,
	'error_class' => 'form__item--invalid'
];

$content = renderTemplate('templates/login.php', $login_data );

$layout_data = [
    'title' => 'Вход',
    'categories' => $categories_list,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));

?>