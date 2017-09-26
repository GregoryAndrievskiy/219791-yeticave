<?php

	$errors = $templateData['errors'];
	$categories = $templateData['categories'];
	$default_error_class = 'form__item--invalid';

?>
<form class="form container" action="login.php" method="post"> <!-- form--invalid -->
	<h2>Вход</h2>
	<div class="form__item <?=in_array('login-email',$errors) ? $default_error_class : ''?>"> <!-- form__item--invalid -->
		<label for="email">E-mail*</label>
		<input id="email" type="text" name="login-email" placeholder="Введите e-mail" required value="<?=$_POST['login-email'];?>">
		<span class="form__error">Введите e-mail</span>
	</div>
	<div class="form__item form__item--last <?=in_array('login-password',$errors) ? $default_error_class : ''?>">
		<label for="password">Пароль*</label>
		<input id="password" type="text" name="login-password" placeholder="Введите пароль" required value="<?=$_POST['login-password'];?>">
		<span class="form__error">Введите пароль</span>
	</div>
	<button type="submit" class="button">Войти</button>
</form>
