<?php

$errors = $templateData['errors'];
$categories = $templateData['categories'];
$default_error_text = 'Заполните это поле';
$numeric_error_text = 'Введите число';
$default_error_class = 'form__item--invalid';

?>
<form class="form form--add-lot container <?=count($errors) ? 'form--invalid' : ''?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
<h2>Добавление лота</h2>
<div class="form__container-two">
  <div class="form__item <?=in_array('lot-name',$errors) ? $default_error_class : ''?>"> <!-- form__item--invalid -->
	<label for="lot-name">Наименование</label>
	<input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" required  value="<?=$_POST['lot-name'];?>">
	<span class="form__error"><?=in_array('lot-name',$errors) ? $default_error_text : ''?></span>
  </div>
  <div class="form__item <?=in_array('lot-category',$errors) ? $default_error_class : ''?>">
	<label for="category">Категория</label>
	<select id="category" name="lot-category" required>
		<option value='' <?=empty($errors) ? 'selected' : ''?>>Выберите категорию</option>
		<? foreach ($categories as $key => $value) : ?>
			<option value="<?=$value['id'];?>" <?=($_POST['lot-category'] == $value['id'] ) ? 'selected' : ''?>><?=$value['name'];?></option>
		<? endforeach ?>
	</select>
	<span class="form__error"><?=in_array('lot-category',$errors) ? $default_error_text : ''?></span>
  </div>
</div>
<div class="form__item form__item--wide <?=in_array('lot-message',$errors) ? $default_error_class : ''?>">
  <label for="message">Описание</label>
  <textarea id="message" name="lot-message" placeholder="Напишите описание лота" required><?=$_POST['lot-message'];?></textarea>
  <span class="form__error"><?=in_array('lot-message',$errors) ? $default_error_text : ''?></span>
</div>
<div class="form__item form__item--file"> <!-- form__item--uploaded -->
  <label>Изображение</label>
  <div class="preview">
	<button class="preview__remove" type="button">x</button>
	<div class="preview__img">
	  <img src="../img/avatar.jpg" width="113" height="113" alt="Изображение лота">
	</div>
  </div>
  <div class="form__input-file">
	<input class="visually-hidden" type="file" id="photo2" name="lot-photo">
	<label for="photo2">
	  <span>+ Добавить</span>
	</label>
  </div>
</div>
<div class="form__container-three">
  <div class="form__item form__item--small <?=in_array('lot-rate',$errors) ? $default_error_class : ''?>">
	<label for="lot-rate">Начальная цена</label>
	<input id="lot-rate" type="number" name="lot-rate" placeholder="0" required  value="<?=$_POST['lot-rate'];?>">
	<span class="form__error"><?=in_array('lot-rate',$errors) ? $numeric_error_text : ''?></span>
  </div>
  <div class="form__item form__item--small <?=in_array('lot-step',$errors) ? $default_error_class : ''?>">
	<label for="lot-step">Шаг ставки</label>
	<input id="lot-step" type="number" name="lot-step" placeholder="0" required  value="<?=$_POST['lot-step'];?>">
	<span class="form__error"><?=in_array('lot-step',$errors) ? $numeric_error_text : ''?></span>
  </div>
  <div class="form__item <?=in_array('lot-date',$errors) ? $default_error_class : ''?>">
	<label for="lot-date">Дата завершения</label>
	<input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="20.05.2017" required  value="<?=$_POST['lot-date'];?>">
	<span class="form__error"><?=in_array('lot-date',$errors) ? $default_error_text : ''?></span>
  </div>
</div>
<span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
<button type="submit" class="button">Добавить лот</button>
</form>