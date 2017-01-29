create table appuser (
	username varchar(255) primary key,
	password varchar(255),
	fname varchar(127),
	lname varchar(127),
	email varchar(255), 
	type varchar(20)
	lastclick lon);

create table classes (
	name varchar(127),
	instructor varchar(255),
	code varchar(50), 
	igetit INTEGER,
	idontgetit INTEGER,
	PRIMARY KEY(name,instructor));
