-- MySQL Script generated by MySQL Workbench
-- Tue Jan  3 15:48:11 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`actualités`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`actualités` (
                                                   `id_Actualités` INT(11) NOT NULL,
                                                   `Titre` VARCHAR(255) NULL DEFAULT NULL,
                                                   `Date` VARCHAR(255) NULL DEFAULT NULL,
                                                   `Texte` VARCHAR(255) NULL DEFAULT NULL,
                                                   PRIMARY KEY (`id_Actualités`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`salle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`salle` (
                                              `id_Salle` INT(11) NOT NULL,
                                              `Nom` VARCHAR(255) NULL DEFAULT NULL,
                                              `Adresse` VARCHAR(255) NULL DEFAULT NULL,
                                              `NuT` VARCHAR(255) NULL DEFAULT NULL,
                                              PRIMARY KEY (`id_Salle`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`borne`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`borne` (
                                              `id_Borne` INT(11) NOT NULL,
                                              `Nom` VARCHAR(255) NULL DEFAULT NULL,
                                              `salle_id_Salle` INT(11) NOT NULL,
                                              PRIMARY KEY (`id_Borne`, `salle_id_Salle`),
                                              INDEX `fk_borne_salle1_idx` (`salle_id_Salle` ASC),
                                              CONSTRAINT `fk_borne_salle1`
                                                  FOREIGN KEY (`salle_id_Salle`)
                                                      REFERENCES `mydb`.`salle` (`id_Salle`)
                                                      ON DELETE NO ACTION
                                                      ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`période`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`période` (
                                                `id_Période` INT(11) NOT NULL,
                                                `DaF` VARCHAR(255) NULL DEFAULT NULL,
                                                `DaD` VARCHAR(255) NULL DEFAULT NULL,
                                                PRIMARY KEY (`id_Période`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`personne`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`personne` (
                                                 `id_Personne` INT(11) NOT NULL,
                                                 `Prénom` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Nom` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Adresse` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Ville` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Rôle` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Sexe` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Identifiant` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Mot_De_Passe` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Utilisateur` TINYINT NULL,
                                                 `période_id_Période` INT(11) NOT NULL,
                                                 PRIMARY KEY (`id_Personne`, `période_id_Période`),
                                                 INDEX `fk_personne_période1_idx` (`période_id_Période` ASC),
                                                 CONSTRAINT `fk_personne_période1`
                                                     FOREIGN KEY (`période_id_Période`)
                                                         REFERENCES `mydb`.`période` (`id_Période`)
                                                         ON DELETE NO ACTION
                                                         ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`bracelet`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`bracelet` (
                                                 `id_Bracelet` INT(11) NOT NULL,
                                                 `Nom` VARCHAR(255) NULL DEFAULT NULL,
                                                 `salle_id_Salle` INT(11) NOT NULL,
                                                 `personne_id_Personne` INT(11) NOT NULL,
                                                 PRIMARY KEY (`id_Bracelet`, `salle_id_Salle`, `personne_id_Personne`),
                                                 INDEX `fk_bracelet_salle1_idx` (`salle_id_Salle` ASC),
                                                 INDEX `fk_bracelet_personne1_idx` (`personne_id_Personne` ASC),
                                                 CONSTRAINT `fk_bracelet_salle1`
                                                     FOREIGN KEY (`salle_id_Salle`)
                                                         REFERENCES `mydb`.`salle` (`id_Salle`)
                                                         ON DELETE NO ACTION
                                                         ON UPDATE NO ACTION,
                                                 CONSTRAINT `fk_bracelet_personne1`
                                                     FOREIGN KEY (`personne_id_Personne`)
                                                         REFERENCES `mydb`.`personne` (`id_Personne`)
                                                         ON DELETE NO ACTION
                                                         ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`capteurbo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`capteurbo` (
                                                  `id_Capteur` INT NOT NULL,
                                                  `Nom` VARCHAR(255) NULL DEFAULT NULL,
                                                  `Unité` VARCHAR(255) NULL DEFAULT NULL,
                                                  `borne_id_Borne` INT(11) NOT NULL,
                                                  PRIMARY KEY (`id_Capteur`, `borne_id_Borne`),
                                                  INDEX `fk_capteur_borne1_idx` (`borne_id_Borne` ASC),
                                                  CONSTRAINT `fk_capteur_borne1`
                                                      FOREIGN KEY (`borne_id_Borne`)
                                                          REFERENCES `mydb`.`borne` (`id_Borne`)
                                                          ON DELETE NO ACTION
                                                          ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`cgu`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`cgu` (
                                            `id_CGU` INT(11) NOT NULL,
                                            `text` VARCHAR(255) NULL DEFAULT NULL,
                                            PRIMARY KEY (`id_CGU`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`contact` (
                                                `id_Contact` INT(11) NOT NULL,
                                                `Row1` VARCHAR(255) NULL DEFAULT NULL,
                                                `Row2` VARCHAR(255) NULL DEFAULT NULL,
                                                `Row3` VARCHAR(255) NULL DEFAULT NULL,
                                                PRIMARY KEY (`id_Contact`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`faq`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`faq` (
                                            `id_FAQ` INT(11) NOT NULL,
                                            `TiQ` VARCHAR(255) NULL DEFAULT NULL,
                                            `ReQ` VARCHAR(255) NULL DEFAULT NULL,
                                            PRIMARY KEY (`id_FAQ`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`mesurebo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`mesurebo` (
                                                 `id_Mesure` INT(11) NOT NULL,
                                                 `Nom` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Date` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Heure` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Valeur` VARCHAR(255) NULL DEFAULT NULL,
                                                 `capteur_id_Capteur` INT NOT NULL,
                                                 PRIMARY KEY (`id_Mesure`, `capteur_id_Capteur`),
                                                 INDEX `fk_mesure_capteur1_idx` (`capteur_id_Capteur` ASC),
                                                 CONSTRAINT `fk_mesure_capteur1`
                                                     FOREIGN KEY (`capteur_id_Capteur`)
                                                         REFERENCES `mydb`.`capteurbo` (`id_Capteur`)
                                                         ON DELETE NO ACTION
                                                         ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`objectif`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`objectif` (
                                                 `id_Objectif` INT NOT NULL,
                                                 `Des` VARCHAR(255) NULL DEFAULT NULL,
                                                 `DaF` VARCHAR(255) NULL DEFAULT NULL,
                                                 `DaD` VARCHAR(255) NULL DEFAULT NULL,
                                                 `personne_id_Personne` INT(11) NOT NULL,
                                                 INDEX `fk_objectif_personne1_idx` (`personne_id_Personne` ASC),
                                                 CONSTRAINT `fk_objectif_personne1`
                                                     FOREIGN KEY (`personne_id_Personne`)
                                                         REFERENCES `mydb`.`personne` (`id_Personne`)
                                                         ON DELETE NO ACTION
                                                         ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`capteurbr`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`capteurbr` (
                                                  `id_Capteur` INT NOT NULL,
                                                  `Nom` VARCHAR(255) NULL DEFAULT NULL,
                                                  `Unité` VARCHAR(255) NULL DEFAULT NULL,
                                                  `bracelet_id_Bracelet` INT(11) NOT NULL,
                                                  `bracelet_salle_id_Salle` INT(11) NOT NULL,
                                                  PRIMARY KEY (`id_Capteur`, `bracelet_id_Bracelet`, `bracelet_salle_id_Salle`),
                                                  INDEX `fk_capteurbr_bracelet1_idx` (`bracelet_id_Bracelet` ASC, `bracelet_salle_id_Salle` ASC),
                                                  CONSTRAINT `fk_capteurbr_bracelet1`
                                                      FOREIGN KEY (`bracelet_id_Bracelet` , `bracelet_salle_id_Salle`)
                                                          REFERENCES `mydb`.`bracelet` (`id_Bracelet` , `salle_id_Salle`)
                                                          ON DELETE NO ACTION
                                                          ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`mesurebr`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`mesurebr` (
                                                 `id_Mesure` INT(11) NOT NULL,
                                                 `Nom` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Date` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Heure` VARCHAR(255) NULL DEFAULT NULL,
                                                 `Valeur` VARCHAR(255) NULL DEFAULT NULL,
                                                 `capteurbr_id_Capteur` INT NOT NULL,
                                                 PRIMARY KEY (`id_Mesure`, `capteurbr_id_Capteur`),
                                                 INDEX `fk_mesurebr_capteurbr1_idx` (`capteurbr_id_Capteur` ASC),
                                                 CONSTRAINT `fk_mesurebr_capteurbr1`
                                                     FOREIGN KEY (`capteurbr_id_Capteur`)
                                                         REFERENCES `mydb`.`capteurbr` (`id_Capteur`)
                                                         ON DELETE NO ACTION
                                                         ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;