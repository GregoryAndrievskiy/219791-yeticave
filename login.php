<?php

session_start();

require_once ('vendor/autoload.php');

require_once 'functions.php';

require_once 'mysql_helper.php';

require_once 'init.php';

$select_data_user = select_data($con, 'SELECT name, email, avatar_url, id, password FROM user ORDER by user.id');

$error_list = [];

if (!empty($_POST)) {
	
	$user;
	$email = $_POST['login-email'];
	$password = $_POST['login-password'];

	if ($user = searchUserByEmail($email, $select_data_user)) {

		if (password_verify($password, $user['password'])) {

			$_SESSION['user'] = $user;
			header("Location: /index.php");

		} else {

			$error_list[] = 'login-password';

		};
	} else {

		$error_list[] = 'login-email';

	};
};

$login_data = [
	'errors' => $error_list,
	'categories' => $select_data_categories
];

$content = renderTemplate('templates/login.php', $login_data );

$layout_data = [
    'title' => 'Вход',
    'categories' => $select_data_categories,
	'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));

?>