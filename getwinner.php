<?php

require_once 'init.php';

$expireQuery = 'SELECT 
	lot.id,
	lot.name,
	(SELECT bet.user_id FROM bet 
WHERE bet.lot_id = lot.id 
ORDER BY bet.bet_date DESC LIMIT 1) as winner_id
FROM lot 
WHERE lot.winner_id is NULL AND lot.expire_date <= NOW()';

$expired_lots = select_data($con, $expireQuery);

forEach($expired_lots as $key => $value) {
	if ($value) {
		
		$winnerIdQuery = 'UPDATE lot SET winner_id = ? WHERE lot.id = ?';
			
		exec_query($con, $winnerIdQuery, [$value['winner_id'], $value['id']]);
		
		$winnerQuery = 'SELECT name, email FROM user WHERE id= ?';
		
		$winner = select_data($con, $winnerQuery, [$value['winner_id']])[0];
		
		$content = [
			'name' => $winner['name'],
			'lot_url' => 'lot.php?id='.$value['id'],
			'lot_name' => $value['name']
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
		
		print($letter);
	}
};
?>