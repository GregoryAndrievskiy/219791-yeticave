<?php

/**
 * Рассчет времени, прошедшего с заданного момента
 *
 * @param string $timeStamp метка заданного момента
 *
 * @return string
 */

function timeManagement($timeStamp) {

	$passedTime = time() - strtotime($timeStamp);
	$hours = floor($passedTime / 3600);
	$time;
	if ($hours >= 24) {

		$time = date("d.m.y в H:i", strtotime($timeStamp));

	} elseif ($hours >= 1) {

		$time = $hours . ' часов назад';

	} else {

		$time = floor(($passedTime % 3600) / 60) . ' минут назад';

	}
	return $time;
};

/**
 * Рассчет времени, оставшегося заданного момента
 *
 * @param string $expire метка заданного момента
 *
 * @return string
 */

function timeRemaining($expire) {
	
	$expire_time;
	$remainingTime = strtotime($expire) - time();
	$days = floor($remainingTime / 3600 / 24);
	$hours = floor($remainingTime % (3600 * 24) / 3600);
	$minutes =  floor(($remainingTime % 3600) / 60);
	if ($days > 1) {
		
		$expire_time = sprintf('%02d дней, %02d:%02d',$days,$hours,$minutes);
		
	} else {
		
		$expire_time = sprintf('%02d:%02d',$hours,$minutes);
		
	}
	return $expire_time;
};

/**
 * Функция шаблонизации
 *
 * @param string $templatePath путь к HTML-шаблону
 * @param array $templateData данные для вставки в шаблон
 *
 * @return string Сгенерированный шаблон
 */


function renderTemplate($templatePath, $templateData) {
	
    if(file_exists($templatePath)) {

        ob_start();
        require $templatePath;
        $html = ob_get_clean();
        return $html;

    }
    return '';
};

/**
 * Поиск пользователя с заданным почтовым адресом
 *
 * @param $con соединение с бд
 * @param string $email искомый почтовый адрес
 *
 * @return array с данными пользователя иди bool false если пользователь не найден
 */
function search_user_by_email($con, $email) {
	
	$userQuery = 'SELECT 
		id,
		name, 
		email, 
		avatar_url, 
		password 
	FROM user 
	WHERE email = ?';
	
	$select_data_user = select_data($con, $userQuery, ['email' => $email])[0];
	
	if ($select_data_user) {
		return [
			'id' => $select_data_user['id'],
			'email' => $select_data_user['email'],
			'password' => $select_data_user['password'],
			'name' => $select_data_user['name'],
			'avatar_url' => $select_data_user['avatar_url']
		];
	
	}
	return false;
};

/**
 * Функция получения данных из БД
 *
 * @param $con ресурс соединения
 * @param $query SQL-запрос
 * @param array $data Опционально передаваемые значения
 *
 * @return array массив с данными
 *
 */
function select_data($con, $query, $data = []) {

    $stmt = db_get_prepare_stmt($con, $query, $data);
    $rows = [];

	if ($stmt) {

		$exe = mysqli_stmt_execute($stmt);

		if($exe) {

			$result = mysqli_stmt_get_result($stmt);

		} if ($result) {

			$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
		}
	}
	return $rows;
};

/**
 * Функция вставки данных в БД
 *
 * @param $con ресурс соединения
 * @param $table Таблица mysql, с которой будет происходить работа
 * @param array $data Вставляемые значения
 *
 * @return bool|id
 *
 */

function insert_data($con, $table, $data = []) {

    $keys = [];
    $values = [];
	$count = [];
	
    foreach ($data as $key => $value) {
        $keys[] = $key;
        $values[] = $value;
		$count[] = '?';
    }
	
	$keys_string = implode(',', $keys);
	$count_string = implode(',', $count);

    $query = 'INSERT INTO ' . $table . '( ' . $keys_string . ') VALUES (' . $count_string . ')';
	
	$stmt = db_get_prepare_stmt($con, $query, $values);
    
	if ($stmt) {
		
		$exe =  mysqli_stmt_execute($stmt);

		if($exe) {

			return mysqli_stmt_insert_id($stmt);
		}
    }
	return false;
};

/**
 * Функция выполнения произвольного запроса (кроме SELECT И INSERT)
 *
 * @param $con ресурс соединения
 * @param $query SQL-запрос
 * @param array $data Передаваемые значения
 * @return bool
 *
 */

function exec_query($con, $query, $data = []) {

    $stmt = db_get_prepare_stmt($con, $query, $data);

    if ($stmt) {

		$exe =  mysqli_stmt_execute($stmt);

		if($exe) {

			return true;
		}
    }
    return $result;
};

/**
* Вычисляет параметр OFFSET для SQL запроса
*
* @param integer $current_page - текущая страница
* @param integer $items_per_page - количество элементов на странице
* @return integer
*/
function get_offset($current_page,$items_per_page)
{
	if (is_numeric($current_page)) {
		$offset = (intval($current_page) - 1) * $items_per_page;
	} else {
		$offset = 0;
	}
	
	return $offset;
};

/**
* Возвращает массив для построения пагинации
* 
* @param integer $items_per_page - количество элементов на странице
* @param integer $items_count - общее количество
* @return array
*/
function get_pagination_range($items_per_page,$items_count)
{

	if ($items_count > 0) {
		$page_count = ceil($items_count / $items_per_page);
	} else {
		$page_count = 1;
	}

	$pages = range(1, $page_count);
	return $pages;
};

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
};

/**
 * Проверка на файл изображения
 *
 * @param $img Файл из массива $_FILES
 *
 * @return bool
 */
function check_filetype($img) {
	
	if ($img) {

		$valid_img_types = ['image/png', 'image/jpeg'];
		$file_type = mime_content_type($img);
	
		foreach ($valid_img_types as $key) {
			
			if ($file_type === $key) {
				
				return true;
			}
		}
	}
	return false;
};
/**
 * Переименовывает и сохраняет файл в указануюю папку 
 *
 * @param $img Файл из массива $_FILES
 * @param string $prefix - префик для нового названия файла
 *
 * @return путь до сохраненного файла
 */
function save_file($img, $prefix) {

	$file_name = uniqid($prefix);
	$file_path = __DIR__ . '/img/';
	move_uploaded_file($img , $file_path . $file_name);
	return 'img/' . $file_name;

};
/**
 * Проверка заполнения обязательных полей в форме
 *
 * @param array $fields массив со значениями
 * @param array $requried - массив с обязательными для заполнения полями
 *
 * @return array полей из $required которые не были заполнены
 */
function get_empty_required($fields, $requried) {
	
	$empty_fields = [];

	foreach ($requried as $key => $value) {
		
		if (!$fields[$value]) {
			
			$empty_fields[] = $value;
		}
	}
	return $empty_fields;
};

/**
 * Проверка заполнения обязательных полей в форме
 *
 * @param string $id идентификатор категории
 * @param array $categories_list  - список категорий
 *
 * @return array с совпашей категорией или bool false
 */
function get_category_by_id($id, $categories_list) {
	
	$category = [];

	foreach ($categories_list as $key => $value) {
		
		if ($value['id'] == $id) {
			
			$category[] = $value;
		}
	}

	if (!empty($category)) {
		
		return $category;
	
	} 
	return false;
};
?>