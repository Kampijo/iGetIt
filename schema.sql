create table appuser (
	username varchar(20) primary key,
	password varchar(20),
	fName varchar(20),
	lName varchar(20),
	email varchar(100), 
	type varchar(20));

create table classes (
	name varchar(20),
	instructor varchar(50),
	code varchar(50), 
	PRIMARY KEY(name,instructor));


