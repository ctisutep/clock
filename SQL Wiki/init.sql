-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema clock
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema clock
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `clock` DEFAULT CHARACTER SET latin1 ;
USE `clock` ;

-- -----------------------------------------------------
-- Table `clock`.`admins`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clock`.`admins` (
  `username` VARCHAR(32) NOT NULL,
  `password` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `clock`.`employees`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clock`.`employees` (
  `ID` INT(11) NOT NULL,
  `Class` TEXT NULL DEFAULT NULL,
  `Name` TEXT NULL DEFAULT NULL,
  `EID` VARCHAR(255) NULL DEFAULT '0',
  `PI` VARCHAR(255) NULL DEFAULT NULL,
  `Hours` VARCHAR(255) NULL DEFAULT '19',
  PRIMARY KEY (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `clock`.`logs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clock`.`logs` (
  `ID` INT(11) NOT NULL,
  `checkedIn` TINYINT(1) NOT NULL,
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `time` INT(11) NULL DEFAULT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
