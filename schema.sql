CREATE DATABASE yeticave;

USE yeticave;

CREATE TABLE category (
	id 						INT AUTO_INCREMENT PRIMARY KEY,
	name					CHAR(13)
);

CREATE INDEX category_name ON categories(name);

CREATE TABLE lot (
	id						INT AUTO_INCREMENT PRIMARY KEY,
	create_date				DATETIME,
	name					CHAR(128),
	description				TEXT,
	img_url					CHAR(64),
	start_price				INT,
	expire_date				DATETIME,
	bet_step				INT,
	number_of_favorite 		INT,

	author_id				INT,
	winner_id				INT,
	category_id				INT
);

CREATE INDEX lot_name ON lot(name);
CREATE INDEX lot_category ON lot(category_id);

CREATE TABLE bet (
	id						INT AUTO_INCREMENT PRIMARY KEY,
	bet_date				DATETIME,
	cost					INT,

	user_id					INT,
	lot_id					INT
);

CREATE INDEX bet_cost ON bet(cost);

CREATE TABLE user (
	id						INT AUTO_INCREMENT PRIMARY KEY,
	registration_date		DATETIME,
	email					CHAR(64),
	name					CHAR(64),
	password				CHAR(64),
	avatar_url				CHAR(64),
	contacts				TEXT,
	
	created_lots_id			INT,
	bets_id					INT
);

CREATE INDEX user_name ON user(name);

CREATE UNIQUE INDEX user_email ON users(email);
