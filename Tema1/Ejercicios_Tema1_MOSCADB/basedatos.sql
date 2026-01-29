-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-09-2023 a las 17:13:01
-- Versión del servidor: 8.0.34-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
-- Base de datos de la mosca


CREATE TABLE `usuario`(
    `id` int AUTO_INCREMENT PRIMARY KEY,
    `usuario` varchar(100) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    `correo` varchar(255) NOT NULL UNIQUE
);


INSERT INTO `usuario` (`usuario`, `password`) VALUES (  'admin', 'admin' );



CREATE TABLE `tablero`(
    `id` int AUTO_INCREMENT PRIMARY KEY,
    `cadena` TEXT NOT NULL,
    `finalizada` BOOLEAN DEFAULT FALSE,
    `creador` int NOT NULL,
    FOREIGN KEY (`creador`) REFERENCES `usuario`(`id`) ON DELETE CASCADE
);


CREATE TABLE `rol`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` varchar(100) NOT NULL
);

INSERT INTO `rol` (`nombre`) VALUES ('admin'), ('jugador'), ('invitado');

CREATE TABLE `usuario_rol`(
    `usuario` int NOT NULL,
    `rol` int NOT NULL,
    FOREIGN KEY (`usuario`) REFERENCES `usuario`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`rol`) REFERENCES `rol`(`id`) ON DELETE CASCADE,
    PRIMARY KEY (`usuario`, `rol`)

);




INSERT INTO `usuario_rol` (`usuario`, `rol`) VALUES (1, 1);