<?php

require_once 'init.php';

$winners = [];
$noWinnerQuery = 'SELECT id FROM lot WHERE winner_id IS NULL AND expire_date < NOW()';

$lots_without_winner = select_data($con, $noWinnerQuery);

$query = 'SELECT 
		user.id AS user_id, 
		user.name AS user_name, 
		user.email, 
		lot.id AS lot_id, 
		lot.name
	FROM bet
	INNER JOIN lot ON bet.lot_id = lot.id
	INNER JOIN user ON bet.user_id = user.id
	WHERE lot_id= ?
	ORDER BY bet.id DESC
	LIMIT 1 OFFSET 0';
	
$updateWinnerQuery = 'UPDATE lot SET winner_id = ? WHERE lot.id = ?';

if ($lots_without_winner) {

    foreach ($lots_without_winner as $key) {
		
        $temp = select_data($con, $query, [$key['id']]);
		
		if ($temp) {
			
			extract($temp[0], EXTR_SKIP);
			exec_query($con, $updateWinnerQuery, [$temp[0]['user_id'], $key['id']]);
			$winners[] = $temp[0];
        }
    }
}

foreach ($winners as $winner) {

	$content = [
		'name' => $winner['user_name'],
		'lot_url' => 'lot.php?id='.$winner['lot_id'],
		'lot_name' => $winner['name']
	];

	$letter = renderTemplate('templates/email.php', $content);

	$transport = new Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl');
	$transport->setUsername('doingsdone@mail.ru');
	$transport->setPassword('rds7BgcL');

	$message = new Swift_Message();
	$message->setSubject('Ваш ставка победила');
	$message->setFrom('doingsdone@mail.ru');
	$message->setTo($winner['email']);
	$message->setContentType('text/html');
	$message->setBody($letter);
	$mailer = new Swift_Mailer($transport);
	$mailer->send($message);
}

?>