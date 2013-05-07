-- drop table jea_export_free
DROP TABLE IF EXISTS #__jea_export_free;
DROP TABLE IF EXISTS #__jea_export_annonce;
DROP TABLE IF EXISTS #__jea_amenities;
DROP TABLE IF EXISTS #__jea_heatingtypes;
DROP TABLE IF EXISTS #__jea_cook;
DROP TABLE IF EXISTS #__jea_types;

CREATE TABLE IF NOT EXISTS `#__jea_export_free` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `code_agence` varchar(45) NOT NULL DEFAULT '',
  `num_boutique` varchar(45) NOT NULL DEFAULT '',
  `ftp_account` varchar(45) NOT NULL DEFAULT '',
  `ftp_password` varchar(45) NOT NULL,
  `ftp_address` varchar(30) NOT NULL,
  `activated` enum('0','1') NOT NULL DEFAULT '0',
  `last_export` datetime DEFAULT NULL,
  `nb_export` int(5) NOT NULL DEFAULT '0',
  `signup_link` varchar(150) NOT NULL,
  `pasrl_ref` varchar(25) NOT NULL,
  `method` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- insert values into jea_export_free
INSERT INTO `#__jea_export_free` (`id`, `name`, `code_agence`, `num_boutique`, `ftp_account`, `ftp_password`, `ftp_address`, `activated`, `last_export`, `nb_export`, `signup_link`, `pasrl_ref`, `method`) VALUES
(1, 'Boom-immo.fr', '', '', '', '', '188.165.233.184', '0', NULL, 0, 'http://www.boomimmo.fr/fr/inscription.htm', 'boomimmo', 'poliris'),
(2, 'Web-immobilier.fr', '', '', '', '', 'cercle.o2switch.net', '0', NULL, 0, 'http://www.web-immobilier.fr', 'webimmo', 'webimmo'),
(3, 'Trovit.fr', '', '', '', '', '', '0', NULL, 0, 'http://immo.trovit.fr', 'trovit', 'trovit');


-- creation table annonce
CREATE TABLE IF NOT EXISTS `#__jea_export_annonce` (
	`id` int(11) NOT NULL,
	`ref` varchar(10) NOT NULL,
	`cook` varchar(50),
	`seller_name` varchar(45),
	`phone` varchar(10),
	`manda_date` date,
	`pasrl_id` varchar(100),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- insert properties present at install
INSERT INTO #__jea_export_annonce (id, ref)
SELECT id, ref FROM #__jea_properties WHERE `published` = 1;

-- creation table equipement
CREATE TABLE IF NOT EXISTS `#__jea_amenities` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`value` varchar(255) NOT NULL,
	`ordering` int(11) DEFAULT 0,
	`language` char(7),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- insert amenities
INSERT INTO #__jea_amenities (`id`, `value`) VALUES
(1, 'Ascenseur'),
(2, 'Cave'),
(3, 'Parking'),
(4, 'Digicode'),
(5, 'Interphone'),
(6, 'Gardien'),
(7, 'Terrasse'),
(8, 'Alarme'),
(9, 'Climatisation'),
(10, 'Piscine'),
(11, 'Amenagements Handicapes'),
(12, 'Cheminee');

-- creation table heating type
CREATE TABLE IF NOT EXISTS `#__jea_heatingtypes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`value` varchar(255) NOT NULL,
	`ordering` int(11) DEFAULT 0,
	`language` char(7),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- insert heatingtypes
INSERT INTO #__jea_heatingtypes (`id`, `value`) VALUES
(128, 'Radiateur'),
(256, 'Sol'),
(384, 'Mixte'),
(512, 'Gaz'),
(640, 'Gaz Radiateur'),
(768, 'Gaz Sol'),
(896, 'Gaz Mixte'),
(1024, 'Fioul'),
(1152, 'Fioul Radiateur'),
(1280, 'Fioul Sol'),
(1408, 'Fioul Mixte'),
(2048, 'Electrique'),
(2176, 'Electrique Radiateur'),
(2304, 'Electrique Sol'),
(2432, 'Electrique Mixte'),
(4096, 'Collectif'),
(4224, 'Collectif Radiateur'),
(4352, 'Collectif Sol'),
(4480, 'Collectif Mixe'),
(4608, 'Collectif Gaz'),
(4736, 'Collectif Gaz Radiateur'),
(4864, 'Collectif Gaz Sol'),
(4992, 'Collectif Gaz Mixte'),
(5120, 'Collectif Fioul'),
(5248, 'Collectif Fioul Radiateur'),
(5376, 'Collectif Fioul Sol'),
(5504, 'Collectif Fioul Mixte'),
(6144, 'Collectic Electrique'),
(6272, 'Collectif Electrique Radiateur'),
(6400, 'Collectif Electrique Sol'),
(6528, 'Collectif Electrique Mixte'),
(8192, 'Individuel'),
(8320, 'Individuel Radiateur'),
(8448, 'Individuel Sol'),
(8576, 'Individuel Mixte'),
(8704, 'Individuel Gaz'),
(8832, 'Individuel Gaz Radiateur'),
(8960, 'Individuel Gaz Sol'),
(9088, 'Individuel Gaz Mixte'),
(9216, 'Individuel Fioul'),
(9344, 'Individuel Fioul Radiateur'),
(9472, 'Individuel Fioul Sol'),
(9600, 'Individuel Fioul Mixte'),
(10240, 'Individuel Electrique'),
(10368, 'Individuel Electrique Radiateur'),
(10496, 'Individuel Electrique Sol'),
(10624, 'Individuel Electrique Mixte');

-- create table cook
CREATE TABLE IF NOT EXISTS `#__jea_cook` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`value` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- insert cook
INSERT INTO #__jea_cook (`id`, `value`) VALUES
(1, 'Aucune'),
(2, 'Americaine'),
(3, 'Separee'),
(4, 'Industrielle'),
(5, 'Coin Cuisine'),
(6, 'Americaine Equipee'),
(7, 'Separee Equipee'),
(8, 'Coin Cuisine Equipe'),
(9, 'Equipee');

-- create table types
CREATE TABLE IF NOT EXISTS `#__jea_types` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`value` varchar(255) NOT NULL,
	`ordering` int(11) DEFAULT 0,
	`language` char(7),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- insert types
INSERT INTO #__jea_types (`id`, `value`) VALUES
(1, 'Maison'),
(2, 'Appartement'),
(3, 'Batiment'),
(4, 'Boutique'),
(5, 'Bureaux'),
(6, 'Chateau'),
(7, 'Immeuble'),
(8, 'Local'),
(9, 'Loft'),
(10, 'Parking'),
(11, 'Terrain');

-- alter table jea_properties
ALTER TABLE #__jea_properties
MODIFY heating_type int(11);