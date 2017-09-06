<?php
$category_value = [];
$tmp_value = [];
$error_list = [];
$error_text = [];
foreach ($_POST as $key => $value) { 
	$tmp_value[$key] = $value;
};
if(!$templateData['lot-form']) {
	$form_form_invalid = 'form--invalid';
	foreach ($_POST as $key => $value) { 
		$tmp_value[$key] = $value;
		if ($key === 'lot-category') $category_value[$value] = 'selected';
		if (!$templateData[$key]) {
			$error_list[$key] = 'form__item--invalid';
			$error_text[$key] = 'заполните поле';
			if ($key === 'lot-category') $error_text[$key] = 'выберите категорию';
		};
	};
};
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
        <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" required  value="<?=$tmp_value['lot-name'];?>">
        <span class="form__error"><?=$error_text['lot-name'];?></span>
      </div>
      <div class="form__item <?=$error_list['lot-category'];?>">
        <label for="category">Категория</label>
        <select id="category" name="lot-category" required>
          <option <?=$category_value['Выберите категорию'];?>>Выберите категорию</option>
          <option <?=$category_value['Доски и лыжи'];?>>Доски и лыжи</option>
          <option <?=$category_value['Крепления'];?>>Крепления</option>
          <option <?=$category_value['Ботинки'];?>>Ботинки</option>
          <option <?=$category_value['Одежда'];?>>Одежда</option>
          <option <?=$category_value['Инструменты'];?>>Инструменты</option>
          <option <?=$category_value['Разное'];?>>Разное</option>
        </select>
        <span class="form__error"><?=$error_text['lot-category'];?></span>
      </div>
    </div>
    <div class="form__item form__item--wide <?=$error_list['lot-message'];?>">
      <label for="message">Описание</label>
      <textarea id="message" name="lot-message" placeholder="Напишите описание лота" required><?=$tmp_value['lot-message'];?></textarea>
      <span class="form__error"><?=$error_text['lot-message'];?></span>
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
        <input class="visually-hidden" type="file" id="photo2" value="<?=$tmp_value['lot-photo'];?>" name="lot-photo">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
    </div>
    <div class="form__container-three">
      <div class="form__item form__item--small <?=$error_list['lot-rate'];?>">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="lot-rate" placeholder="0" required  value="<?=$tmp_value['lot-rate'];?>">
        <span class="form__error"><?=$error_text['lot-rate'];?></span>
      </div>
      <div class="form__item form__item--small <?=$error_list['lot-step'];?>">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="lot-step" placeholder="0" required  value="<?=$tmp_value['lot-step'];?>">
        <span class="form__error"><?=$error_text['lot-steo'];?></span>
      </div>
      <div class="form__item <?=$error_list['lot-date'];?>">
        <label for="lot-date">Дата завершения</label>
        <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="20.05.2017" required  value="<?=$tmp_value['lot-date'];?>">
        <span class="form__error"><?=$error_text['lot-date'];?></span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
  </form>
</main>