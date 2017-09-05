<?php
$name_tmp_value = null;
$category_tmp_value = null;
$message_tmp_value = null;
$photo_tmp_value = null;
$rate_tmp_value = null;
$step_tmp_value = null;
$date_tmp_value = null;

$inpit_value_error = 'заплните поле';
$invalid_class = 'form__item--invalid';
if(!$templateData['form']) {
	$form_form_invalid = 'form--invalid';
	$name_tmp_value = $_POST['lot-name'];
	$category_tmp_value = $_POST['lot-category'];
	$message_tmp_value = $_POST['lot-message'];
	$photo_tmp_value = $_POST['lot-photo'];
	$rate_tmp_value = $_POST['lot-rate'];
	$step_tmp_value = $_POST['lot-step'];
	$date_tmp_value = $_POST['lot-date'];
} else {
	$name_tmp_value = null;
	$category_tmp_value = null;
	$message_tmp_value = null;
	$photo_tmp_value = null;
	$rate_tmp_value = null;
	$step_tmp_value = null;
	$date_tmp_value = null;
}
if(!$templateData['name']) {
	$form_name_invalid = $invalid_class;
	$form_name_error = $inpit_value_error;
}
if(!$templateData['category']) {
	$form_category_invalid = $invalid_class;
	$form_category_error = 'выберите категорию';
}
if(!$templateData['message']) {
	$form_message_invalid = $invalid_class;
	$form_message_error = $inpit_value_error;
}
if(!$templateData['photo']) {
	$form_photo_invalid = $invalid_class;
	$form_photo_error = 'загрузите изображение';
}
if(!$templateData['rate']) {
	$form_rate_invalid = $invalid_class;
	$form_rate_error = $inpit_value_error;
}
if(!$templateData['step']) {
	$form_step_invalid = $invalid_class;
	$form_step_error = $inpit_value_error;
}
if(!$templateData['date']) {
	$form_date_invalid = $invalid_class;
	$form_date_error = $inpit_value_error;
}
?>
<main>
  <nav class="nav">
    <ul class="nav__list container">
      <li class="nav__item">
        <a href="all-lots.html">Доски и лыжи</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Крепления</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Ботинки</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Одежда</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Инструменты</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Разное</a>
      </li>
    </ul>
  </nav>
  <form class="form form--add-lot container <?=$form_form_invalid;?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
      <div class="form__item <?=$form_name_invalid;?>"> <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" required  value="<?=$name_tmp_value;?>">
        <span class="form__error"><?=$form_name_error;?></span>
      </div>
      <div class="form__item <?=$form_category_invalid;?>">
        <label for="category">Категория</label>
        <select id="category" name="lot-category" required  value="<?=$category_tmp_value;?>">
          <option>Выберите категорию</option>
          <option>Доски и лыжи</option>
          <option>Крепления</option>
          <option>Ботинки</option>
          <option>Одежда</option>
          <option>Инструменты</option>
          <option>Разное</option>
        </select>
        <span class="form__error"><?=$form_category_error;?></span>
      </div>
    </div>
    <div class="form__item form__item--wide <?=$form_message_invalid;?>">
      <label for="message">Описание</label>
      <textarea id="message" name="lot-message" placeholder="Напишите описание лота" required  value="<?=$message_tmp_value;?>"></textarea>
      <span class="form__error"><?=$form_message_error;?></span>
    </div>
    <div class="form__item form__item--file <?=$form_photo_invalid;?>"> <!-- form__item--uploaded -->
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="../img/avatar.jpg" width="113" height="113" alt="Изображение лота">
        </div>
      </div>
      <div class="form__input-file <?=$form_photo_invalid;?>">
        <input class="visually-hidden" type="file" id="photo2" value="<?=$photo_tmp_value;?>" name="lot-photo">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
    </div>
    <div class="form__container-three">
      <div class="form__item form__item--small <?=$form_rate_invalid;?>">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="lot-rate" placeholder="0" required  value="<?=$rate_tmp_value;?>">
        <span class="form__error"><?=$form_rate_error;?></span>
      </div>
      <div class="form__item form__item--small <?=$form_step_invalid;?>">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="lot-step" placeholder="0" required  value="<?=$step_tmp_value;?>">
        <span class="form__error"><?=$form_step_error;?></span>
      </div>
      <div class="form__item <?=$form_date_invalid;?>">
        <label for="lot-date">Дата завершения</label>
        <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="20.05.2017" required  value="<?=$date_tmp_value;?>">
        <span class="form__error"><?=$form_date_error;?></span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
  </form>
</main>