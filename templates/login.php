<form class="form container" action="login.php" method="post"> <!-- form--invalid -->
	<? if(!empty($_GET['reg'])):?>
		<? if($_GET['reg'] === 'ok'):?>
			<h2>Теперь вы можете войти, используя свой email и пароль</h2>
		<? endif; ?>
	<? endif; ?>
	<h2>Вход</h2>
	<div class="form__item <?=in_array('login-email', $templateData['errors']) ? $templateData['error_class'] : ''?>"> <!-- form__item--invalid -->
		<label for="email">E-mail*</label>
		<input id="email" type="text" name="login-email" placeholder="Введите e-mail" required value="<?=!empty($_POST['login-email']) ? $_POST['login-email'] : ''?>">
		<span class="form__error">Введите e-mail</span>
	</div>
	<div class="form__item form__item--last <?=in_array('login-password',$templateData['errors']) ? $templateData['error_class'] : ''?>">
		<label for="password">Пароль*</label>
		<input id="password" type="text" name="login-password" placeholder="Введите пароль" required value="<?=!empty($_POST['login-password']) ? $_POST['login-password'] : ''?>">
		<span class="form__error">Введите пароль</span>
	</div>
	<button type="submit" class="button">Войти</button>
</form>
