-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mintaegyesületek2
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mintaegyesületek2` ;

-- -----------------------------------------------------
-- Schema mintaegyesületek2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mintaegyesületek2` DEFAULT CHARACTER SET utf8 ;
USE `mintaegyesületek2` ;

-- -----------------------------------------------------
-- Table `mintaegyesületek2`.`tagok`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mintaegyesületek2`.`tagok` (
  `idtagok` INT NOT NULL AUTO_INCREMENT,
  `tagnév` VARCHAR(45) NOT NULL,
  `született` DATE NOT NULL,
  `tagokcol` VARCHAR(45) NULL,
  PRIMARY KEY (`idtagok`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mintaegyesületek2`.`egyesület`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mintaegyesületek2`.`egyesület` (
  `idegyesület` INT NOT NULL AUTO_INCREMENT,
  `egyesületnev` VARCHAR(45) NOT NULL,
  `alapitaseve` INT NOT NULL,
  `tagdij` INT NULL,
  `alapittagok_idtagok` INT NOT NULL,
  PRIMARY KEY (`idegyesület`, `alapittagok_idtagok`),
  INDEX `fk_egyesület_tagok1_idx` (`alapittagok_idtagok` ASC),
  CONSTRAINT `fk_egyesület_tagok1`
    FOREIGN KEY (`alapittagok_idtagok`)
    REFERENCES `mintaegyesületek2`.`tagok` (`idtagok`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mintaegyesületek2`.`tagok_has_egyesület`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mintaegyesületek2`.`tagok_has_egyesület` (
  `tagok_idtagok` INT NOT NULL,
  `egyesület_idegyesület` INT NOT NULL,
  `csatlakozas` INT NOT NULL,
  PRIMARY KEY (`tagok_idtagok`, `egyesület_idegyesület`),
  INDEX `fk_tagok_has_egyesület_egyesület1_idx` (`egyesület_idegyesület` ASC),
  INDEX `fk_tagok_has_egyesület_tagok_idx` (`tagok_idtagok` ASC),
  CONSTRAINT `fk_tagok_has_egyesület_tagok`
    FOREIGN KEY (`tagok_idtagok`)
    REFERENCES `mintaegyesületek2`.`tagok` (`idtagok`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tagok_has_egyesület_egyesület1`
    FOREIGN KEY (`egyesület_idegyesület`)
    REFERENCES `mintaegyesületek2`.`egyesület` (`idegyesület`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

 
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO tagok(tagnév, született) VALUES
('Tamás Evelin', '1946-12-01'),
('Bálint Olívia', '1980-06-18'),
('Kozma Ottó', '1990-01-30'),
('Juhász András', '1981-09-27'),
('Török Gábor', '1975-05-13');

INSERT INTO egyesület(egyesületnev, alapitaseve, tagdij, alapittagok_idtagok) VALUES
('CSS kedvelők szövetsége', 2017, 2700, 2),
('Informatikusok országos szövetsége', 1980, 3000, 5),
('PHP programozók társasága', 2010, 4500, 4),
('SQL adatbázist használók egyesülete', 2001, 5000, 3);


INSERT INTO tagok_has_egyesület(egyesület_idegyesület, tagok_idtagok, csatlakozas) VALUES
(1, 3, 2014), (1, 4, 2019), (1, 1, 2020), (1, 2, 2017),
(2, 1, 2020), (2, 2, 1990), (2, 5, 1980), 
(3, 1, 2020), (3, 4, 2010),
(4, 3, 2001);


-- SELECT egyesület.egyesületnev, tagok.tagnév FROM egyesület INNER JOIN tagok ON egyesület.alapittagok_idtagok=tagok.idtagok group by egyesületnev
 SELECT tagok.idtagok FROM tagok WHERE tagok.tagnév LIKE "%Török%"
 
 