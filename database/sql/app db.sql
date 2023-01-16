-- MySQL Script generated by MySQL Workbench
-- Mon Jan 16 11:19:59 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema APP DB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema APP DB
-- -----------------------------------------------------
DROP SCHEMA `APP DB`;
CREATE SCHEMA IF NOT EXISTS `APP DB` DEFAULT CHARACTER SET utf8 ;
USE `APP DB` ;

-- -----------------------------------------------------
-- Table `APP DB`.`Client`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Client` (
  `cltID` CHAR(255) NOT NULL,
  `cltToken` VARCHAR(255) NULL,
  `cltUsername` VARCHAR(50) NOT NULL,
  `cltFirstName` VARCHAR(50) NOT NULL,
  `cltLastName` VARCHAR(50) NOT NULL,
  `cltEmail` VARCHAR(50) NOT NULL,
  `cltPfpName` VARCHAR(255) NULL,
  `cltPhoneNumber` CHAR(10) NOT NULL,
  `cltPassword` VARCHAR(255) NOT NULL,
  `cltSignupDate` DATETIME NOT NULL DEFAULT NOW(),
  `cltVerifiedEmail` TINYINT NOT NULL DEFAULT 0,
  `cltIsModerator` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`cltID`),
  UNIQUE INDEX `cltEmail_UNIQUE` (`cltEmail` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Address`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Address` (
  `adrID` CHAR(255) NOT NULL,
  `adrAddress` VARCHAR(255) NOT NULL,
  `adrAddressOptional` VARCHAR(255) NOT NULL,
  `adrPostalCode` VARCHAR(255) NOT NULL,
  `adrCity` VARCHAR(45) NOT NULL,
  `adrDefault` TINYINT NOT NULL DEFAULT 0,
  `Client_cltID` CHAR(255) NOT NULL,
  PRIMARY KEY (`adrID`, `Client_cltID`),
  INDEX `fk_Address_Client1_idx` (`Client_cltID` ASC),
  CONSTRAINT `fk_Address_Client1`
    FOREIGN KEY (`Client_cltID`)
    REFERENCES `APP DB`.`Client` (`cltID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Product` (
  `prdID` CHAR(255) NOT NULL,
  `prdName` VARCHAR(30) NOT NULL,
  `prdPrice` DECIMAL(10,2) NOT NULL,
  `prdReleaseDate` DATE NOT NULL,
  PRIMARY KEY (`prdID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Basket`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Basket` (
  `basID` CHAR(255) NOT NULL,
  `basDate` DATETIME NOT NULL DEFAULT NOW(),
  `Client_cltID` CHAR(255) NOT NULL,
  PRIMARY KEY (`basID`, `Client_cltID`),
  INDEX `fk_Basket_Client1_idx` (`Client_cltID` ASC),
  CONSTRAINT `fk_Basket_Client1`
    FOREIGN KEY (`Client_cltID`)
    REFERENCES `APP DB`.`Client` (`cltID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Order_History`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Order_History` (
  `orhID` CHAR(255) NOT NULL,
  `orhStatus` VARCHAR(10) NOT NULL,
  `orhDate` DATE NOT NULL,
  `Client_cltID` CHAR(255) NOT NULL,
  PRIMARY KEY (`orhID`, `Client_cltID`),
  INDEX `fk_Order_History_Client1_idx` (`Client_cltID` ASC),
  CONSTRAINT `fk_Order_History_Client1`
    FOREIGN KEY (`Client_cltID`)
    REFERENCES `APP DB`.`Client` (`cltID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Device`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Device` (
  `devID` CHAR(255) NOT NULL,
  `prdID` VARCHAR(255) NOT NULL,
  `prcColor` VARCHAR(255) NOT NULL,
  `Client_cltID` CHAR(255) NOT NULL,
  PRIMARY KEY (`devID`, `Client_cltID`),
  INDEX `fk_Device_Client1_idx` (`Client_cltID` ASC),
  CONSTRAINT `fk_Device_Client1`
    FOREIGN KEY (`Client_cltID`)
    REFERENCES `APP DB`.`Client` (`cltID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Product_List`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Product_List` (
  `prdLstID` CHAR(255) NOT NULL,
  `prcColor` VARCHAR(255) NULL,
  `Product_prdID` CHAR(255) NOT NULL,
  `Basket_basID` CHAR(255) NOT NULL,
  PRIMARY KEY (`prdLstID`, `Product_prdID`, `Basket_basID`),
  INDEX `fk_Product_List_Product_idx` (`Product_prdID` ASC),
  INDEX `fk_Product_List_Basket1_idx` (`Basket_basID` ASC),
  CONSTRAINT `fk_Product_List_Product`
    FOREIGN KEY (`Product_prdID`)
    REFERENCES `APP DB`.`Product` (`prdID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Product_List_Basket1`
    FOREIGN KEY (`Basket_basID`)
    REFERENCES `APP DB`.`Basket` (`basID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Data_Device`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Data_Device` (
  `dapID` CHAR(255) NOT NULL,
  `dapBPM` INT NOT NULL,
  `dapLatitude` DECIMAL(8,6) NOT NULL,
  `dapLongitude` DECIMAL(9,6) NOT NULL,
  `dapCO2` DECIMAL(3,2) NOT NULL,
  `dapGaz` DECIMAL(3,2) NOT NULL,
  `dapDecibel` INT NOT NULL,
  `dapTemp` INT NOT NULL,
  `dapTime` TIME NOT NULL,
  `dapDate` DATE NOT NULL,
  `Device_devID` CHAR(255) NOT NULL,
  PRIMARY KEY (`dapID`, `Device_devID`),
  INDEX `fk_Data_Device_Device1_idx` (`Device_devID` ASC),
  CONSTRAINT `fk_Data_Device_Device1`
    FOREIGN KEY (`Device_devID`)
    REFERENCES `APP DB`.`Device` (`devID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Payment_Method`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Payment_Method` (
  `mdpID` CHAR(255) NOT NULL,
  `pamType` VARCHAR(20) NOT NULL,
  `pamCardNum` CHAR(16) NOT NULL,
  `pamCVV` CHAR(3) NOT NULL,
  `pamCardExpiryDate` CHAR(4) NOT NULL,
  `Client_cltID` CHAR(255) NOT NULL,
  PRIMARY KEY (`mdpID`, `Client_cltID`),
  INDEX `fk_Payment_Method_Client1_idx` (`Client_cltID` ASC),
  CONSTRAINT `fk_Payment_Method_Client1`
    FOREIGN KEY (`Client_cltID`)
    REFERENCES `APP DB`.`Client` (`cltID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Admin` (
  `admID` CHAR(255) NOT NULL,
  `admToken` VARCHAR(255) NULL,
  `admUsername` VARCHAR(20) NOT NULL,
  `admFirstName` VARCHAR(255) NULL,
  `admLastName` VARCHAR(255) NULL,
  `admEmail` VARCHAR(30) NOT NULL,
  `admPfpName` VARCHAR(255) NULL,
  `admPhoneNumber` CHAR(10) NULL,
  `admPassword` VARCHAR(255) NOT NULL,
  `admSignupDate` DATETIME NULL DEFAULT NOW(),
  `admVerifiedEmail` TINYINT NULL DEFAULT 0,
  PRIMARY KEY (`admID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Session_Message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Session_Message` (
  `sesMsgID` VARCHAR(255) NOT NULL,
  `sesMsgStartDate` DATETIME NOT NULL DEFAULT NOW(),
  `sesMsgEndDate` DATETIME NULL,
  `Client_cltID` CHAR(255) NOT NULL,
  PRIMARY KEY (`sesMsgID`, `Client_cltID`),
  INDEX `fk_Session_Message_Client1_idx` (`Client_cltID` ASC),
  CONSTRAINT `fk_Session_Message_Client1`
    FOREIGN KEY (`Client_cltID`)
    REFERENCES `APP DB`.`Client` (`cltID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Client_Message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Client_Message` (
  `cltMsgID` CHAR(255) NOT NULL,
  `cltMsgMessage` VARCHAR(255) NOT NULL,
  `cltMsgDate` DATETIME NOT NULL DEFAULT NOW(),
  `Client_cltID` CHAR(255) NOT NULL,
  `Session_Message_sesMsgID` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`cltMsgID`, `Client_cltID`, `Session_Message_sesMsgID`),
  INDEX `fk_Client_Message_Client1_idx` (`Client_cltID` ASC),
  INDEX `fk_Client_Message_Session_Message1_idx` (`Session_Message_sesMsgID` ASC),
  CONSTRAINT `fk_Client_Message_Client1`
    FOREIGN KEY (`Client_cltID`)
    REFERENCES `APP DB`.`Client` (`cltID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Client_Message_Session_Message1`
    FOREIGN KEY (`Session_Message_sesMsgID`)
    REFERENCES `APP DB`.`Session_Message` (`sesMsgID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Image` (
  `imgID` CHAR(255) NOT NULL,
  `imgPath` VARCHAR(255) NOT NULL,
  `imgCategory` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`imgID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Assistance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Assistance` (
  `astID` CHAR(255) NOT NULL,
  `astQuestion` VARCHAR(255) NOT NULL,
  `astAnswer` VARCHAR(255) NULL,
  `astDate` DATE NOT NULL DEFAULT now(),
  `astApproved` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`astID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Question`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Question` (
  `qstID` CHAR(255) NOT NULL,
  `qstQuestion` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`qstID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Question_Answers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Question_Answers` (
  `qstRepID` CHAR(255) NOT NULL,
  `qstRepAnswer` VARCHAR(255) NOT NULL,
  `qstRepBool` TINYINT NOT NULL,
  `Question_qstID` CHAR(255) NOT NULL,
  PRIMARY KEY (`qstRepID`, `Question_qstID`),
  INDEX `fk_Question_Answers_Question1_idx` (`Question_qstID` ASC),
  CONSTRAINT `fk_Question_Answers_Question1`
    FOREIGN KEY (`Question_qstID`)
    REFERENCES `APP DB`.`Question` (`qstID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Admin_Message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Admin_Message` (
  `admMsgID` CHAR(255) NOT NULL,
  `admMsgMessage` VARCHAR(255) NOT NULL,
  `admMsgDate` DATETIME NOT NULL DEFAULT NOW(),
  `Admin_admID` CHAR(255) NOT NULL,
  `Session_Message_sesMsgID` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`admMsgID`, `Admin_admID`, `Session_Message_sesMsgID`),
  INDEX `fk_Admin_Message_Admin1_idx` (`Admin_admID` ASC),
  INDEX `fk_Admin_Message_Session_Message1_idx` (`Session_Message_sesMsgID` ASC),
  CONSTRAINT `fk_Admin_Message_Admin1`
    FOREIGN KEY (`Admin_admID`)
    REFERENCES `APP DB`.`Admin` (`admID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Admin_Message_Session_Message1`
    FOREIGN KEY (`Session_Message_sesMsgID`)
    REFERENCES `APP DB`.`Session_Message` (`sesMsgID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Product_Color`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Product_Color` (
  `prcID` VARCHAR(255) NOT NULL,
  `prcColor` VARCHAR(255) NOT NULL,
  `Product_prdID` CHAR(255) NOT NULL,
  PRIMARY KEY (`prcID`, `Product_prdID`),
  INDEX `fk_Product_Color_Product1_idx` (`Product_prdID` ASC),
  CONSTRAINT `fk_Product_Color_Product1`
    FOREIGN KEY (`Product_prdID`)
    REFERENCES `APP DB`.`Product` (`prdID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `APP DB`.`Product_Image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `APP DB`.`Product_Image` (
  `pimID` VARCHAR(255) NOT NULL,
  `pimPath` VARCHAR(255) NOT NULL,
  `Product_Color_prcID` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`pimID`, `Product_Color_prcID`),
  INDEX `fk_Product_Image_Product_Color1_idx` (`Product_Color_prcID` ASC),
  CONSTRAINT `fk_Product_Image_Product_Color1`
    FOREIGN KEY (`Product_Color_prcID`)
    REFERENCES `APP DB`.`Product_Color` (`prcID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
