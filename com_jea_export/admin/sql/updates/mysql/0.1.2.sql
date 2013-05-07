-- create table jea_export_pay
CREATE TABLE #__jea_export_pay (
	id int(4) NOT NULL AUTO_INCREMENT,
	name varchar(25) NOT NULL,
	login varchar(45) NOT NULL,
	password varchar(45) NOT NULL,
	activated ENUM('0', '1') NOT NULL DEFAULT '0',
	last_export DATETIME,
	nb_export int(5) NOT NULL DEFAULT '0',
	PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;