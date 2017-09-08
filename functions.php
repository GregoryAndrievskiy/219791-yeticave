<?php
// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');
// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";
// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');
// временная метка для настоящего времени
$now = time();
// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
$remainingTime = $tomorrow - $now;
$hours = floor($remainingTime / 3600);
$minutes =  floor(($remainingTime % 3600) / 60);
$lot_time_remaining = $lot_time_remaining = sprintf('%02d:%02d',$hours,$minutes);

$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

function renderTemplate($templatePath, $templateData) {
	
    if(file_exists($templatePath)) {

        ob_start();
        require $templatePath;
        $html = ob_get_clean();
        return $html;

    }
    return '';
}

function searchUserByEmail($email, $users) {
	$result = null;

	foreach ($users as $user) {
		if ($user['email'] == $email) {

			$result = $user;
			break;
		}
	}
	return $result;
}
?>