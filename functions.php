<?php

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


function renderTemplate($templatePath, $templateData) {
	
    if(file_exists($templatePath)) {

        ob_start();
        require $templatePath;
        $html = ob_get_clean();
        return $html;

    }
    return '';
};

function searchUserByEmail($email, $users) {

	$result = null;

	foreach ($users as $user) {

		if ($user['email'] == $email) {

			$result = $user;
			break;
		}
	}
	return $result;
};

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
?>