<?php

date_default_timezone_set('Europe/Moscow');

$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

$lots = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '10999',
        'url' => 'img/lot-1.jpg'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '159999',
        'url' => 'img/lot-2.jpg'
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => '8000',
        'url' => 'img/lot-3.jpg'
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => '10999',
        'url' => 'img/lot-4.jpg'
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => '7500',
        'url' => 'img/lot-5.jpg'
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => '5400',
        'url' => 'img/lot-6.jpg'
    ]
];

$old_bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

function timeManagement($timeStamp) {

	$now = time();
	$passedTime = $now - $timeStamp;
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

	$remainingTime = $expire - time();
	$hours = floor($remainingTime / 3600);
	$minutes =  floor(($remainingTime % 3600) / 60);
	$expire_time = sprintf('%02d:%02d',$hours,$minutes);
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

			$rows = mysqli_fetch_array($result, MYSQLI_ASSOC);
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

	//echo $query;
	
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