<?php

date_default_timezone_set('Europe/Moscow');

function timeManagement($timeStamp) {

	$passedTime = time() - strtotime($timeStamp);
	$hours = floor($passedTime / 3600);
	$time;
	if ($hours >= 24) {

		$time = date("d.m.y в H:i", $timeStamp);

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

?>