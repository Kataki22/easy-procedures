-- SQL script to create tables for the easy-procedures database

-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `surname` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phonenumber` INT NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `deleted` TINYINT(1) DEFAULT 0,
  `modified_by` INT DEFAULT NULL,
  `id_role` INT NOT NULL,
  `token` VARCHAR(100) DEFAULT NULL,
  `Verifications` INT DEFAULT NULL,
  `created` DATETIME DEFAULT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `modified_by_UNIQUE` (`modified_by`),
  CONSTRAINT `fk_users_roles` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table `procedures`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `procedures` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(40) NOT NULL,
  `type` VARCHAR(50) NOT NULL,
  `image` VARCHAR(250) DEFAULT NULL,
  `description` TEXT NOT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  `modified_by` INT DEFAULT NULL,
  `created` DATETIME DEFAULT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table `requirementtypes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `requirementtypes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(50) NOT NULL,
  `name` VARCHAR(250) NOT NULL,
  `Description` VARCHAR(50) NOT NULL,
  `deleted` TINYINT(1) DEFAULT 0,
  `created` DATETIME DEFAULT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table `requirements`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `requirements` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NOT NULL,
  `description` VARCHAR(250) NOT NULL,
  `status` VARCHAR(30) NOT NULL,
  `example` VARCHAR(255) DEFAULT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  `modified_by` INT DEFAULT NULL,
  `requirementtype_id` INT NOT NULL,
  `created` DATETIME DEFAULT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_requirements_requirementtypes` FOREIGN KEY (`requirementtype_id`) REFERENCES `requirementtypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table `procedurerequirements`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `procedurerequirements` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `procedure_id` INT NOT NULL,
  `requirement_id` INT NOT NULL,
  `modified_by` INT DEFAULT NULL,
  `created` DATETIME DEFAULT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_procedurerequirements_procedures` FOREIGN KEY (`procedure_id`) REFERENCES `procedures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_procedurerequirements_requirements` FOREIGN KEY (`requirement_id`) REFERENCES `requirements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table `requests`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `requests` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `status` VARCHAR(20) NOT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  `modified_by` INT DEFAULT NULL,
  `user_id` INT NOT NULL,
  `procedure_id` INT NOT NULL,
  `created` DATETIME DEFAULT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_requests_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_requests_procedures` FOREIGN KEY (`procedure_id`) REFERENCES `procedures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table `requestrequirements`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `requestrequirements` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(250) DEFAULT NULL,
  `status` VARCHAR(20) NOT NULL,
  `raison` VARCHAR(500) NOT NULL,
  `procedurerequirement_id` INT NOT NULL,
  `request_id` INT NOT NULL,
  `created` DATETIME DEFAULT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_requestrequirements_procedurerequirements` FOREIGN KEY (`procedurerequirement_id`) REFERENCES `procedurerequirements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_requestrequirements_requests` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table `requirementproprieties`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `requirementproprieties` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(50) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `label` VARCHAR(250) NOT NULL,
  `description` VARCHAR(250) DEFAULT NULL,
  `default_value` VARCHAR(50) DEFAULT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  `requirement_id` INT NOT NULL,
  `created` DATETIME DEFAULT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_requirementproprieties_requirements` FOREIGN KEY (`requirement_id`) REFERENCES `requirements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Table `requestrequirementproprieties`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `requestrequirementproprieties` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NOT NULL,
  `value` VARCHAR(50) NOT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  `requirementpropriety_id` INT NOT NULL,
  `requestrequirement_id` INT NOT NULL,
  `created` DATETIME DEFAULT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_requestreqprop_reqprop` FOREIGN KEY (`requirementpropriety_id`) REFERENCES `requirementproprieties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_requestreqprop_requestreq` FOREIGN KEY (`requestrequirement_id`) REFERENCES `requestrequirements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
