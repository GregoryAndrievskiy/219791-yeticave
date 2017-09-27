<?php

	$errors = $templateData['errors'];
	$default_error_class = 'form__item--invalid';
	$default_error_text = 'Заполните это поле';

?>
<form class="form container <?=count($errors) ? 'form--invalid' : ''?>" action="sign-up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
	<h2>Регистрация нового аккаунта</h2>
	<div class="form__item <?=in_array('reg-email',$errors) ? $default_error_class : ''?>"> <!-- form__item--invalid -->
		<label for="email">E-mail*</label>
		<input id="email" type="text" name="reg-email" placeholder="Введите e-mail" required value="<?=$_POST['reg-email'];?>">
		<span class="form__error"></span>
	</div>
	<div class="form__item <?=in_array('password',$errors) ? $default_error_class : ''?>">
		<label for="password">Пароль*</label>
		<input id="password" type="text" name="password" placeholder="Введите пароль" required value="<?=$_POST['password'];?>">
		<span class="form__error"></span>
	</div>
	<div class="form__item <?=in_array('name',$errors) ? $default_error_class : ''?>">
		<label for="name">Имя*</label>
		<input id="name" type="text" name="name" placeholder="Введите имя" required value="<?=$_POST['name'];?>">
		<span class="form__error"></span>
	</div>
	<div class="form__item <?=in_array('message',$errors) ? $default_error_class : ''?>">
		<label for="message">Контактные данные*</label>
		<textarea id="message" name="message" placeholder="Напишите как с вами связаться" required><?=$_POST['message'];?></textarea>
		<span class="form__error"></span>
	</div>
	<div class="form__item form__item--file form__item--last">
		<label>Изображение</label>
		<div class="preview">
			<button class="preview__remove" type="button">x</button>
			<div class="preview__img">
				<img src="../img/avatar.jpg" width="113" height="113" alt="Изображение лота">
			</div>
		</div>
		<div class="form__input-file">
			<input class="visually-hidden" type="file" id="photo2" name="img_url" value="">
			<label for="photo2">
				<span>+ Добавить</span>
			</label>
		</div>
	</div>
	<span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
	<button type="submit" class="button">Зарегистрироваться</button>
	<a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>
