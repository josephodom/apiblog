CREATE TABLE IF NOT EXISTS posts (
	pid int unsigned primary key not null auto_increment,
	title varchar(255),
	message text,
	date_created int unsigned,
	date_last_edited int unsigned
);