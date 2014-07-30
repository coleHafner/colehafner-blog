CREATE TABLE `post` (
	`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` varchar(255) DEFAULT NULL,
	`body` text DEFAULT NULL,
	`created` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	`updated` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	`archived` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	PRIMARY KEY (`id`)
) ENGINE=`InnoDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin COMMENT='';

CREATE TABLE `comment` (
	`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`post_id` int(10) UNSIGNED NOT NULL,
	`content` text DEFAULT NULL,
	`created` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	`updated` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	`archived` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	PRIMARY KEY (`id`),
	FOREIGN KEY (`post_id`) REFERENCES `blog`.`post` (`id`)   ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=`InnoDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin COMMENT='';

CREATE TABLE `user` (
	`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(255) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`type` tinyint(1) NOT NULL,
	`created` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	`updated` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	`archived` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	PRIMARY KEY (`id`)
) ENGINE=`InnoDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin COMMENT='';

CREATE TABLE `session` (
	`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`hash` VARCHAR(255) NOT NULL,
	`user_id` int(10) UNSIGNED NOT NULL,
	`user_agent` VARCHAR(255) DEFAULT NULL,
	`ip_address` VARCHAR(255) DEFAULT NULL,
	`created` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	`updated` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	`archived` int(10) UNSIGNED DEFAULT NULL COMMENT 'timestamp',
	PRIMARY KEY (`id`),
	UNIQUE (`hash`),
	FOREIGN KEY (`user_id`) REFERENCES `blog`.`user` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=`InnoDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin COMMENT='';