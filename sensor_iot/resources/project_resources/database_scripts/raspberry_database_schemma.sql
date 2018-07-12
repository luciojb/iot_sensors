CREATE SCHEMA IF NOT EXISTS `sensor_db` DEFAULT CHARACTER SET utf8 ;
USE `sensor_db` ;

-- -----------------------------------------------------
-- Table `sensor_db`.`sensor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sensor_db`.`sensor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `identifier` VARCHAR(45) NOT NULL,
  `temperature` DOUBLE NOT NULL,
  `humidity` DOUBLE NOT NULL,
  `readed_at` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `identifier_UNIQUE` (`identifier` ASC))
ENGINE = InnoDB;
