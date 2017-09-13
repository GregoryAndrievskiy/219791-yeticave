INSERT INTO category SET name = 'Доски и лыжи';
INSERT INTO category SET name = 'Крепления';
INSERT INTO category SET name = 'Ботинки';
INSERT INTO category SET name = 'Одежда';
INSERT INTO category SET name = 'Инструменты';
INSERT INTO category SET name = 'Разное';

INSERT INTO user SET
	registration_date = '2017-09-11 00:00:00',
	email = 'ignat.v@gmail.com',
	name = 'Игнат',
	password = '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka',
	avatar_url = 'img/avatar.jpg',
	contacts = '8-812-777-44-22';

INSERT INTO user SET
	registration_date = '2017-09-11 00:00:00',
	email = 'kitty_93@li.ru',
	name = 'Леночка',
	password = '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa',
	avatar_url = 'img/avatar.jpg',
	contacts = '8-812-777-44-22';

INSERT INTO user SET
	registration_date = '2017-09-11 00:00:00',
	email = 'warrior07@mail.ru',
	name = 'Руслан',
	password = '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW',
	avatar_url = 'img/avatar.jpg',
	contacts = '8-812-777-44-22';
	
INSERT INTO lot SET
	create_date = '2017-09-11 00:00:00',
	name = '2014 Rossignol District Snowboard',
	description = 'Доска',
	img_url = 'img/lot-1.jpg',
	start_price = 10999,
	expire_date = '2017-10-12 00:00:00',
	bet_step = 0,
	number_of_favorite = 0,
	author_id = 2,
	winner_id = null,
	category_id = 1;

INSERT INTO lot SET
	create_date = '2017-09-12 09:00:00',
	name = 'DC Ply Mens 2016/2017 Snowboard',
	description = 'Ещё доска',
	img_url = 'img/lot-2.jpg',
	start_price = 15999,
	expire_date = '2017-10-12 00:00:00',
	bet_step = 0,
	number_of_favorite = 0,
	author_id = 1,
	winner_id = null,
	category_id = 1;

INSERT INTO lot SET
	create_date = '2017-09-11 00:00:00',
	name = 'Крепления Union Contact Pro 2015 года размер L/XL',
	description = 'Крепления',
	img_url = 'img/lot-3.jpg',
	start_price = 8000,
	expire_date = '2017-10-12 00:00:00',
	bet_step = 0,
	number_of_favorite = 0,
	author_id = 2,
	winner_id = null,
	category_id = 2;

INSERT INTO lot SET
	create_date = '2017-09-11 00:00:00',
	name = 'Ботинки для сноуборда DC Mutiny Charocal',
	description = '',
	img_url = 'img/lot-4.jpg',
	start_price = 10999,
	expire_date = '2017-10-12 00:00:00',
	bet_step = 0,
	number_of_favorite = 0,
	author_id = 3,
	winner_id = null,
	category_id = 3;

INSERT INTO lot SET
	create_date = '2017-09-11 00:00:00',
	name = 'Куртка для сноуборда DC Mutiny Charocal',
	description = '',
	img_url = 'img/lot-5.jpg',
	start_price = 7500,
	expire_date = '2017-10-12 00:00:00',
	bet_step = 0,
	number_of_favorite = 0,
	author_id = 1,
	winner_id = null,
	category_id = 4;

INSERT INTO lot SET
	create_date = '2017-09-11 00:00:00',
	name = 'Маска Oakley Canopy',
	description = '',
	img_url = 'img/lot-6.jpg',
	start_price = 5400,
	expire_date = '2017-10-12 00:00:00',
	bet_step = 0,
	number_of_favorite = 0,
	author_id = 3,
	winner_id = null,
	category_id = 6;

INSERT INTO bet SET
	bet_date = '2017-09-13 09:00:00',
	cost = 11111,
	user_id	= 3,
	lot_id = 1;

INSERT INTO bet SET
	bet_date = '2017-09-13 11:00:00',
	cost = 12222,
	user_id = 1,
	lot_id = 1;


SELECT name FROM category;


SELECT
	name,
	start_price,
	img_url,
	category_id,
	IFNULL(MAX(bet.cost), lot.start_price) as bet_price,
	COUNT(bet.lot_id) as bets_number
FROM lot
LEFT JOIN bet ON bet.lot_id = lot.id
WHERE lot.expire_date > NOW()
GROUP BY lot.id
ORDER BY lot.expire_date DESC;


SELECT * FROM lot
WHERE name = 'Крепления Union Contact Pro 2015 года размер L/XL' OR description LIKE 'Крепления';


UPDATE lot SET name = 'Крепления Union Contact Pro 2017 года размер M'
WHERE id = 1;


SELECT * FROM bet
WHERE lot_id = 1 ORDER BY bet_date DESC;