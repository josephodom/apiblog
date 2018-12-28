CREATE TABLE IF NOT EXISTS users (
	uid int unsigned primary key not null auto_increment,
	username varchar(255),
	password varchar(255),
	date_created int unsigned
);