-- MySQL Script generated by MySQL Workbench
-- Fri Nov  1 21:29:19 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema dbz
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `dbz` ;

-- -----------------------------------------------------
-- Schema dbz
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbz` ;
USE `dbz` ;

-- -----------------------------------------------------
-- Table `dbz`.`answers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbz`.`answers` ;

CREATE TABLE IF NOT EXISTS `dbz`.`answers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `answer` VARCHAR(256) NOT NULL,
  `is_correct` TINYINT NOT NULL DEFAULT 0,
  `question_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE INDEX (`answer` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  INDEX `fk_answers_perguntas1_idx` (`question_id` ASC) VISIBLE,
  CONSTRAINT `fk_answers_perguntas1`
    FOREIGN KEY (`question_id`)
    REFERENCES `dbz`.`questions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `dbz`.`points`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbz`.`points` ;

CREATE TABLE IF NOT EXISTS `dbz`.`points` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `points` INT NOT NULL,
  `user_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX `fk_points_user1_idx` (`user_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_points_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `dbz`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `dbz`.`questions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbz`.`questions` ;

CREATE TABLE IF NOT EXISTS `dbz`.`questions` (
  `id` INT NULL DEFAULT NULL AUTO_INCREMENT,
  `question` VARCHAR(256) NOT NULL,
  `points` TINYINT NOT NULL DEFAULT 10,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE INDEX (`question` ASC) VISIBLE,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `dbz`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbz`.`user` ;

CREATE TABLE IF NOT EXISTS `dbz`.`user` (
  `id` INT NULL DEFAULT NULL AUTO_INCREMENT,
  `username` VARCHAR(128) NOT NULL,
  `email` VARCHAR(128) NOT NULL,
  `pass` CHAR(32) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE INDEX (`username` ASC) VISIBLE,
  UNIQUE INDEX (`email` ASC) VISIBLE,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `dbz`.`user_answers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbz`.`user_answers` ;

CREATE TABLE IF NOT EXISTS `dbz`.`user_answers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `answer_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_user_answers_answers1_idx` (`answer_id` ASC) VISIBLE,
  INDEX `fk_user_answers_user1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_user_answers_answers1`
    FOREIGN KEY (`answer_id`)
    REFERENCES `dbz`.`answers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_answers_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `dbz`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
