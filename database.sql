-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 16-09-2020 a las 16:37:17
-- Versión del servidor: 10.5.5-MariaDB-1:10.5.5+maria~focal
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `database`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `username` VARCHAR(50) NOT NULL,
  `psw` VARCHAR(100) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `fotosPeliculas` (
  `idPelicula` INT NOT NULL,
  `user` VARCHAR(50) NOT NULL,
  `path` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idPelicula`, `user`),
  FOREIGN KEY (`idPelicula`) REFERENCES `peliculas` (`idPelicula`),
  FOREIGN KEY (`user`) REFERENCES `usuarios` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`username`, `psw`, `name`, `email`) VALUES
('usuario1', 'contraseña1', 'Nombre Usuario 1', 'usuario1@example.com'),
('usuario2', 'contraseña2', 'Nombre Usuario 2', 'usuario2@example.com'),
('usuario3', 'contraseña3', 'Nombre Usuario 3', 'usuario3@example.com'),
('usuario4', 'contraseña4', 'Nombre Usuario 4', 'usuario4@example.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
