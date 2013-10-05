
/* definitions ratings table */
DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `definition_id` INT(11) NOT NULL,
  `user_ip` VARCHAR(60) NOT NULL,
  `rating` INT(11) NOT NULL,
  PRIMARY KEY (`definition_id`,`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/* definitions media table */
DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `definition_id` INT(11) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `reason` VARCHAR(500) NOT NULL,
  `status` char(1) NOT NULL,
  `content_type` VARCHAR(20) NOT NULL,
  `create_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_user` VARCHAR(50) NOT NULL DEFAULT 'backend',
  `update_user` VARCHAR(50) NOT NULL DEFAULT 'backend',
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_url_unique` (`definition_id`, `url`),
  KEY `definition_id` (`definition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/* expression definitions table */
DROP TABLE IF EXISTS `definitions`;
CREATE TABLE IF NOT EXISTS `definitions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `expression_id` INT(11) NOT NULL,
  `description` VARCHAR(1000) NOT NULL,
  `example` VARCHAR(1000) NOT NULL,
  `tags` VARCHAR(100) NOT NULL,
  `status` char(1) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `create_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_user` VARCHAR(50) NOT NULL DEFAULT 'backend',
  `create_user_ip` VARCHAR(255),
  `update_user` VARCHAR(50) NOT NULL DEFAULT 'backend',
  PRIMARY KEY (`id`),
  KEY `expression_id` (`expression_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `ratings` 
ADD CONSTRAINT `ratings_definition_id_fk` 
FOREIGN KEY (`definition_id`) 
REFERENCES `definitions` (`id`) 
ON DELETE CASCADE;

ALTER TABLE `media` 
ADD CONSTRAINT `media_definition_id_fk` 
FOREIGN KEY (`definition_id`) 
REFERENCES `definitions` (`id`) 
ON DELETE CASCADE;

/* expressions */
DROP TABLE IF EXISTS `expressions`;
CREATE TABLE IF NOT EXISTS `expressions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(255) NOT NULL,
  `letter` char(1) NOT NULL,
  `create_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_user` VARCHAR(50) NOT NULL DEFAULT 'backend',
  `update_user` VARCHAR(50) NOT NULL DEFAULT 'backend',
  PRIMARY KEY (`id`),
  UNIQUE KEY `expressions_expression_unique` (`text`),
  KEY `text_index` (`text`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `definitions` 
ADD CONSTRAINT `definitions_expression_id_fk` 
FOREIGN KEY (`expression_id`) 
REFERENCES `expressions` (`id`) 
ON DELETE CASCADE;

/* subscribers */
DROP TABLE IF EXISTS `subscribers`;
CREATE TABLE IF NOT EXISTS `subscribers`(
  `id` INT(11) NOT NULL AUTO_INCREMENT, 
  `email` VARCHAR(255) NOT NULL, 
  `create_date` DATETIME NULL,
  `update_date` DATETIME NULL,
  `create_user` VARCHAR(50) NOT NULL DEFAULT 'backend',
  `update_user` VARCHAR(50) NOT NULL DEFAULT 'backend', 
  PRIMARY KEY (`id`), 
  UNIQUE KEY `subscribers_email_is_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
