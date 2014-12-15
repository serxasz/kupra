CREATE TABLE IF NOT EXISTS `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`username` varchar(20) NOT NULL,
	`password` varchar(40) NOT NULL,
	`email` varchar(60) NOT NULL,
	`active` int(11) NOT NULL DEFAULT '0',
	`action` int(11) NOT NULL,
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `users_online` (
	`uid` int(11) NOT NULL,
	`time` int(11) NOT NULL,
	`place` char(50) NOT NULL,
	PRIMARY KEY (`uid`)
);
CREATE TABLE IF NOT EXISTS `messages` (
	`mid` int(30) NOT NULL AUTO_INCREMENT,
	`sender` varchar(20) NOT NULL,
	`receiver` varchar(20) NOT NULL,
	`time` DATETIME DEFAULT NULL,
	`message` VARCHAR(2000) NOT NULL,
	`deleted` int(11) NOT NULL DEFAULT '0',
	`new` int(11) NOT NULL DEFAULT '1',
	PRIMARY KEY (`mid`)
);