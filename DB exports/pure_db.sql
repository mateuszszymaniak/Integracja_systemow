-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema systems_integration
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema systems_integration
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `systems_integration` DEFAULT CHARACTER SET utf8 ;
USE `systems_integration` ;

-- -----------------------------------------------------
-- Table `systems_integration`.`beneficiary`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `systems_integration`.`beneficiary` (
  `idbeneficiary` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NULL,
  PRIMARY KEY (`idbeneficiary`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `systems_integration`.`fund_n_programme`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `systems_integration`.`fund_n_programme` (
  `idfund_n_program` INT NOT NULL AUTO_INCREMENT,
  `fund` VARCHAR(4) NULL,
  `programme` VARCHAR(85) NULL,
  `priority` VARCHAR(220) NULL,
  `measure` VARCHAR(310) NULL,
  `submeasure` VARCHAR(230) NULL,
  PRIMARY KEY (`idfund_n_program`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `systems_integration`.`project_location`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `systems_integration`.`project_location` (
  `idproject_location` INT NOT NULL AUTO_INCREMENT,
  `location` VARCHAR(5650) NULL,
  `type` VARCHAR(150) NULL,
  PRIMARY KEY (`idproject_location`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `systems_integration`.`duration`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `systems_integration`.`duration` (
  `idduration` INT NOT NULL AUTO_INCREMENT,
  `start` DATETIME NULL,
  `end` DATETIME NULL,
  PRIMARY KEY (`idduration`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `systems_integration`.`project_information`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `systems_integration`.`project_information` (
  `idproject_information` INT NOT NULL AUTO_INCREMENT,
  `competitive_or_not` ENUM('Konkursowy', 'Pozakonkursowy', 'Nadzwyczajny') NULL,
  `area_of_economic_activity` VARCHAR(150) NULL,
  `area_of_project_intervention` VARCHAR(450) NULL,
  `objective` VARCHAR(830) NULL,
  `esf_secondary_theme` VARCHAR(130) NULL,
  `implemented_under_territorial_delivery_mechanisms` ENUM('Nie dotyczy', 'ZIT', 'RKLS') NULL,
  `funding_complete` ENUM('Nie', 'Tak') NULL,
  PRIMARY KEY (`idproject_information`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `systems_integration`.`project`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `systems_integration`.`project` (
  `idproject` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(1000) NULL,
  `description` VARCHAR(2010) NULL,
  `contract_no` VARCHAR(24) NULL,
  `beneficiary_idbeneficiary` INT NOT NULL,
  `fund_n_programme_idfund_n_program` INT NOT NULL,
  `project_location_idproject_location` INT NOT NULL,
  `duration_idduration` INT NOT NULL,
  `project_information_idproject_information` INT NOT NULL,
  PRIMARY KEY (`idproject`),
  INDEX `fk_project_beneficiary_idx` (`beneficiary_idbeneficiary` ASC) VISIBLE,
  INDEX `fk_project_fund_n_programme1_idx` (`fund_n_programme_idfund_n_program` ASC) VISIBLE,
  INDEX `fk_project_project_location1_idx` (`project_location_idproject_location` ASC) VISIBLE,
  INDEX `fk_project_duration1_idx` (`duration_idduration` ASC) VISIBLE,
  INDEX `fk_project_project_information1_idx` (`project_information_idproject_information` ASC) VISIBLE,
  CONSTRAINT `fk_project_beneficiary`
    FOREIGN KEY (`beneficiary_idbeneficiary`)
    REFERENCES `systems_integration`.`beneficiary` (`idbeneficiary`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_fund_n_programme1`
    FOREIGN KEY (`fund_n_programme_idfund_n_program`)
    REFERENCES `systems_integration`.`fund_n_programme` (`idfund_n_program`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_project_location1`
    FOREIGN KEY (`project_location_idproject_location`)
    REFERENCES `systems_integration`.`project_location` (`idproject_location`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_duration1`
    FOREIGN KEY (`duration_idduration`)
    REFERENCES `systems_integration`.`duration` (`idduration`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_project_information1`
    FOREIGN KEY (`project_information_idproject_information`)
    REFERENCES `systems_integration`.`project_information` (`idproject_information`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `systems_integration`.`finances`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `systems_integration`.`finances` (
  `idfinances` INT NOT NULL AUTO_INCREMENT,
  `total_value` DECIMAL(12,2) NULL,
  `eligible_expenditure` DECIMAL(12,2) NULL,
  `amount_cofinancing` DECIMAL(12,2) NULL,
  `cofinancing_rate` DECIMAL(26,13) NULL,
  `form` VARCHAR(135) NULL,
  `project_idproject` INT NOT NULL,
  PRIMARY KEY (`idfinances`),
  INDEX `fk_finances_project1_idx` (`project_idproject` ASC) VISIBLE,
  CONSTRAINT `fk_finances_project1`
    FOREIGN KEY (`project_idproject`)
    REFERENCES `systems_integration`.`project` (`idproject`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
