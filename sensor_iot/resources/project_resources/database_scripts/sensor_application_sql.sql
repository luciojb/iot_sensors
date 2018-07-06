-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sensor_iot
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sensor_iot
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sensor_iot` DEFAULT CHARACTER SET utf8 ;
USE `sensor_iot` ;

-- -----------------------------------------------------
-- Table `sensor_iot`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sensor_iot`.`users` (
  `id` INT NOT NULL	AUTO_INCREMENT,
  `name` VARCHAR(255),
  `email` VARCHAR(255),
  `password` VARCHAR(255),
  `remember_token` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sensor_iot`.`sensor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sensor_iot`.`sensor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(10) NOT NULL,
  `last_active` TIMESTAMP NOT NULL,
  `latest_data_readed` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sensor_iot`.`users_has_sensor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sensor_iot`.`users_has_sensor` (
  `users_id` INT NOT NULL,
  `sensor_id` INT NOT NULL,
  PRIMARY KEY (`users_id`, `sensor_id`),
  INDEX `fk_users_has_sensor_sensor1_idx` (`sensor_id` ASC),
  INDEX `fk_users_has_sensor_users_idx` (`users_id` ASC),
  CONSTRAINT `fk_users_has_sensor_users`
    FOREIGN KEY (`users_id`)
    REFERENCES `sensor_iot`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_sensor_sensor1`
    FOREIGN KEY (`sensor_id`)
    REFERENCES `sensor_iot`.`sensor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sensor_iot`.`sensor_data`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sensor_iot`.`sensor_data` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `temperature` FLOAT NOT NULL,
  `humidity` FLOAT NOT NULL,
  `sensor_id` INT NOT NULL,
  `readed_at` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_sensor_data_sensor1_idx` (`sensor_id` ASC),
  CONSTRAINT `fk_sensor_data_sensor1`
    FOREIGN KEY (`sensor_id`)
    REFERENCES `sensor_iot`.`sensor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
