CREATE DATABASE yeticave;

USE yeticave;

CREATE TABLE category (
	id 						INT AUTO_INCREMENT PRIMARY KEY,
	category 				CHAR(13)
);

CREATE UNIQUE INDEX category ON category(id);

CREATE TABLE lot (
	id						INT AUTO_INCREMENT PRIMARY KEY,
	date_of_create			DATETIME,
	name					CHAR(128),
	description				TEXT,
	img_url					CHAR(64),
	start_price				INT,
	date_of_expire			DATETIME,
	bet_step				INT,
	number_of_favorite 		INT,

	author_link				INT,
	winner_link				INT,
	category_link			INT
);

CREATE INDEX author_link_user ON user(id);
CREATE INDEX winner_link_user ON user(id);
CREATE INDEX category_link_category ON category(id);

CREATE INDEX lot_name ON lot(name);
CREATE INDEX lot_price ON lot(start_price);
CREATE INDEX lot_category ON lot(category_link);

CREATE UNIQUE INDEX lot ON lot(id);
CREATE UNIQUE INDEX lot_img ON lots(img_url);

CREATE TABLE bet (
	id						INT AUTO_INCREMENT PRIMARY KEY,
	date_of_bet				DATETIME,
	bet_value				INT,

	user_link				INT,
	lot_link				INT
);

CREATE INDEX user_link_user ON user(id);
CREATE INDEX lot_link_lot ON lot(id);

CREATE UNIQUE INDEX bet ON bet(id);

CREATE TABLE user (
	id						INT AUTO_INCREMENT PRIMARY KEY,
	date_of_registration	DATETIME,
	email					CHAR(64),
	name					CHAR(64),
	password				CHAR(64),
	avatar_url				CHAR(64),
	contacts				CHAR(128),
	
	created_lots_link		INT,
	bets_link				INT
);

CREATE INDEX created_lots_link_lot ON lot(id);
CREATE INDEX bets_link_bet ON bet(id);

CREATE INDEX user_name ON user(name);

CREATE UNIQUE INDEX user ON user(id);
CREATE UNIQUE INDEX email ON users(email);
