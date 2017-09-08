<?php
$errors = $templateData['errors'];
$categories = $templateData['categories'];
$default_error_class = 'form__item--invalid';

?>
<main>
  <nav class="nav">
    <ul class="nav__list container">
		<? foreach ($categories as $key => $value) : ?>
			<li class="nav__item">
				<a href="all-lots.html"><?=$value;?></a>
			</li>
		<? endforeach ?>
    </ul>
  </nav>
   <form class="form container" action="login.php" method="post"> <!-- form--invalid -->
		<h2>Вход</h2>
		<div class="form__item <?=in_array('email',$errors) ? $default_error_class : ''?>"> <!-- form__item--invalid -->
			<label for="email">E-mail*</label>
			<input id="email" type="text" name="email" placeholder="Введите e-mail" required value="<?=$_POST['email'];?>">
			<span class="form__error">Введите e-mail</span>
		</div>
		<div class="form__item form__item--last <?=in_array('password',$errors) ? $default_error_class : ''?>">
			<label for="password">Пароль*</label>
			<input id="password" type="text" name="password" placeholder="Введите пароль" required value="<?=$_POST['password'];?>">
			<span class="form__error">Введите пароль</span>
		</div>
		<button type="submit" class="button">Войти</button>
	</form>
</main>