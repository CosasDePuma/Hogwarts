-- -----------------------------------------------------
-- Schema padel
-- -----------------------------------------------------
DROP DATABASE IF EXISTS `padel`;
CREATE DATABASE IF NOT EXISTS `padel` DEFAULT CHARACTER SET utf8;
USE `padel` ;

-- -----------------------------------------------------
-- Table `padel`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`usuario` (
  `usuario_id` INT NOT NULL AUTO_INCREMENT UNIQUE,
  `usuario_nombre` VARCHAR(20) NOT NULL,
  `usuario_apellido` VARCHAR(60) NOT NULL,
  `usuario_email` VARCHAR(60) NOT NULL UNIQUE,
  `usuario_contraseña` VARCHAR(255) NOT NULL,
  `usuario_dni` VARCHAR(9) NOT NULL UNIQUE,
  `usuario_nivel` INT(1) NULL,
  `usuario_sexo` enum('hombre','mujer','otro') NOT NULL,
  `usuario_tipo` enum('administrador','entrenador','deportista') NOT NULL,
  PRIMARY KEY (`usuario_email`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `padel`.`reserva`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`reserva` (
  `reserva_id` INT NOT NULL AUTO_INCREMENT UNIQUE,
  `reserva_hora` TIME NOT NULL,
  `reserva_fecha` DATE NOT NULL,
  `reserva_pista` INT NOT NULL,
  `usuario_email` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`reserva_id`, `usuario_email`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `padel`.`partido_promocionado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`partido_promocionado` (
  `partido_promocionado_id` INT NOT NULL AUTO_INCREMENT UNIQUE,
  `partido_promocionado_hora` TIME NOT NULL,
  `partido_promocionado_fecha` DATE NOT NULL,
  PRIMARY KEY (`partido_promocionado_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `padel`.`usuario_partido_promocionado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`usuario_partido_promocionado` (
  `usuario_id` INT NOT NULL,
  `partido_promocionado_id` INT NOT NULL,
  PRIMARY KEY (`usuario_id`, `partido_promocionado_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `padel`.`campeonato`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`campeonato` (
  `campeonato_id` INT NOT NULL AUTO_INCREMENT UNIQUE,
  `campeonato_nombre` VARCHAR(45) NOT NULL UNIQUE,
  `campeonato_descripcion` VARCHAR(500) NULL,
  `campeonato_nivel` INT NULL,
  `campeonato_sexo` enum('hombre','mujer','mixto') NOT NULL,
  `campeonato_escerrado` BIT NULL,
  PRIMARY KEY (`campeonato_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `padel`.`usuario_campeonato`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`usuario_campeonato` (
  `capitan_id` VARCHAR(60) NOT NULL UNIQUE,
  `compañero_id` VARCHAR(60) NOT NULL UNIQUE,
  `campeonato_id` INT NOT NULL,
  `usuario_campeonato_puntos` INT NOT NULL,
  `usuario_campeonato_fase` INT NULL,
  PRIMARY KEY (`capitan_id`, `compañero_id`, `campeonato_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `padel`.`grupo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`grupo` (
  `grupo_id` INT NOT NULL,
  `campeonato_id` INT NOT NULL,
  PRIMARY KEY (`grupo_id`, `campeonato_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `padel`.`partido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`partido` (
  `partido_id` INT NOT NULL AUTO_INCREMENT UNIQUE,
  `partido_resultado_local` INT NULL,
  `partido_resultado_visitante` INT NULL,
  `fecha` DATE NOT NULL,
  `usuario_local_email` VARCHAR(60) NOT NULL,
  `usuario_visitante_email` VARCHAR(60) NOT NULL,
  `grupo_id` INT NOT NULL,
  `grupo_campeonato_id` INT NOT NULL,
  PRIMARY KEY (`partido_id`, `usuario_local_email`, `usuario_visitante_email`, `grupo_id`, `grupo_campeonato_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `padel`.`informacion_interes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`informacion_interes` (
  `informacion_interes_id` INT NOT NULL AUTO_INCREMENT UNIQUE,
  `informacion_interes_titulo` VARCHAR(45) NOT NULL,
  `informacion_interes_descripcion` VARCHAR(500) NOT NULL,
  `usuario_email` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`informacion_interes_id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `padel`.`pista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`pista` (
  `pista_id` INT NOT NULL AUTO_INCREMENT UNIQUE,
  `pista_suelo` varchar(50) NOT NULL,
  `pista_ubicacion` varchar(50) NOT NULL,
  `pista_pared` varchar(50) NOT NULL,
  PRIMARY KEY (`pista_id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `padel`.`clase`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`clase` (
  `clase_id` INT NOT NULL AUTO_INCREMENT UNIQUE,
  `clase_fecha` date NOT NULL,
  `clase_hora` time NOT NULL,
  `clase_nombre` varchar(40) NOT NULL,
  `clase_descripcion` varchar(100) NOT NULL,
  `entrenador_email` varchar(40) NOT NULL,
  `escuela_deportiva_id` int(11) DEFAULT NULL,
   PRIMARY KEY (`clase_id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `padel`.`asistencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`asistencia` (
  `clase_id` INT NOT NULL,
  `usuario_email` VARCHAR(60) NOT NULL,
  `asistencia` BOOLEAN DEFAULT FALSE,
   PRIMARY KEY (`clase_id`, `usuario_email`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `padel`.`notificaciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `padel`.`notificaciones` (
  `usuario_email` VARCHAR(60) NOT NULL,
  `informacion_interes_id` INT NOT NULL,
  PRIMARY KEY (`usuario_email`,`informacion_interes_id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `padel`.`escuela_deportiva`
-- -----------------------------------------------------
CREATE TABLE `escuela_deportiva` (
  `escuela_deportiva_id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
  `escuela_deportiva_nombre` varchar(45) DEFAULT NULL,
  `escuela_deportiva_fecha_inscripcion` date DEFAULT NULL,
  `escuela_deportiva_fecha_inicio` date DEFAULT NULL,
  `escuela_deportiva_fecha_fin` date DEFAULT NULL,
  `escuela_deportiva_nivel` int(11) DEFAULT NULL,
	PRIMARY KEY (`escuela_deportiva_id`))
ENGINE = InnoDB;

-- Claves Foráneas: partido
ALTER TABLE `padel`.`partido` ADD FOREIGN KEY (`usuario_local_email`) REFERENCES `padel`.`usuario`(`usuario_email`);
ALTER TABLE `padel`.`partido` ADD FOREIGN KEY (`usuario_visitante_email`) REFERENCES `padel`.`usuario`(`usuario_email`);
-- Claves Foráneas: informacion_interes
ALTER TABLE `padel`.`informacion_interes` ADD FOREIGN KEY (`usuario_email`) REFERENCES `padel`.`usuario`(`usuario_email`);
-- Claves Foráneas: grupo
ALTER TABLE `padel`.`grupo` ADD FOREIGN KEY (`campeonato_id`) REFERENCES `padel`.`campeonato`(`campeonato_id`);
-- Claves Foráneas: usuario_campeonato
ALTER TABLE `padel`.`usuario_campeonato` ADD FOREIGN KEY (`campeonato_id`) REFERENCES `padel`.`campeonato`(`campeonato_id`);
ALTER TABLE `padel`.`usuario_campeonato` ADD FOREIGN KEY (`capitan_id`) REFERENCES `padel`.`usuario`(`usuario_email`);
ALTER TABLE `padel`.`usuario_campeonato` ADD FOREIGN KEY (`compañero_id`) REFERENCES `padel`.`usuario`(`usuario_email`);
-- Claves Foráneas: usuario_partido_promocionado
ALTER TABLE `padel`.`usuario_partido_promocionado` ADD FOREIGN KEY (`usuario_id`) REFERENCES `padel`.`usuario`(`usuario_id`);
ALTER TABLE `padel`.`usuario_partido_promocionado` ADD FOREIGN KEY (`partido_promocionado_id`) REFERENCES `padel`.`partido_promocionado`(`partido_promocionado_id`);
-- Claves Foráneas: reserva
ALTER TABLE `padel`.`reserva` ADD FOREIGN KEY (`usuario_email`) REFERENCES `padel`.`usuario`(`usuario_email`);
-- Claves Foráneas: notificaciones
ALTER TABLE `padel`.`notificaciones` ADD FOREIGN KEY (`usuario_email`) REFERENCES `padel`.`usuario`(`usuario_email`);
ALTER TABLE `padel`.`notificaciones` ADD FOREIGN KEY (`informacion_interes_id`) REFERENCES `padel`.`informacion_interes`(`informacion_interes_id`);
-- Claves Foráneas: asistencia
ALTER TABLE `padel`.`asistencia` ADD FOREIGN KEY (`clase_id`) REFERENCES `padel`.`clase`(`clase_id`);
ALTER TABLE `padel`.`asistencia` ADD FOREIGN KEY (`usuario_email`) REFERENCES `padel`.`usuario`(`usuario_email`);
-- Constrains: Reserva
ALTER TABLE `padel`.`reserva` ADD CONSTRAINT uq_reserva UNIQUE (`reserva_fecha`,`reserva_hora`,`reserva_pista`);