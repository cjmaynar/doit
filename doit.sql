CREATE TABLE `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(45) NOT NULL,
`password` varchar(255) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 

CREATE TABLE `tasks` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user` int(11) NOT NULL,
`task` varchar(255) NOT NULL,
`created` datetime NOT NULL,
`completed` datetime DEFAULT NULL,
`due` date DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1
