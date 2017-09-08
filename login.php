<?php

session_start();

require_once 'functions.php';
require_once 'userdata.php';

$error_list = [];

if (!empty($_POST)) {

	$email = $_POST['email'];
	$password = $_POST['password'];

	if ($user = searchUserByEmail($email, $users)) {

		if (password_verify($password, $user['password'])) {

			$_SESSION['user'] = $user;
			header("Location: /index.php");

		} else {

			$error_list[] = 'password';

		};
	} else {

		$error_list[] = 'email';

	};
};

$login_data = [
	'errors' => $error_list,
	'categories' => $categories
];

$content = renderTemplate('templates/login.php', $login_data );

$layout_data = [
    'title' => 'Вход',
    'content' => $content
];

print(renderTemplate('templates/layout.php', $layout_data));
?>