-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2021 a las 08:44:09
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clinica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cirugia`
--

CREATE TABLE `cirugia` (
  `nombre` varchar(35) NOT NULL,
  `correo` varchar(35) NOT NULL,
  `celular` varchar(10) NOT NULL,
  `medico` varchar(50) NOT NULL,
  `sala` varchar(20) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(15) NOT NULL,
  `usuario` varchar(35) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cirugia`
--

INSERT INTO `cirugia` (`nombre`, `correo`, `celular`, `medico`, `sala`, `fecha`, `hora`, `usuario`, `tipo`, `id`) VALUES
('José Solis', 'jsolis@gmail.com', '3331998564', 'José Hernández Salazar', 'Sala 3', '2021-12-02', '16:00', 'agarcia', 'Cirugía', 3),
('Michelle Cárdenas', 'mcardenas@gmail.com', '3365214778', 'José Hernández Salazar', 'Sala 4', '2021-12-02', '16:00', 'jsolis', 'Cirugía', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `nombre` varchar(35) NOT NULL,
  `correo` varchar(35) NOT NULL,
  `celular` varchar(10) NOT NULL,
  `medico` varchar(50) NOT NULL,
  `sala` varchar(15) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(10) NOT NULL,
  `usuario` varchar(35) NOT NULL,
  `tipo` varchar(35) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`nombre`, `correo`, `celular`, `medico`, `sala`, `fecha`, `hora`, `usuario`, `tipo`, `id`) VALUES
('Christopher Encinas', 'cencinas@gmail.com', '3331998564', 'Julieta Herrera Guzmán', 'No aplica', '2021-12-02', '08:00', 'agarcia', 'Cita', 7),
('Christian Castolo', 'ccastolo@gmai.com', '3322569852', 'Julieta Herrera Guzmán', 'No aplica', '2021-12-03', '12:00', 'jsolis', 'Cita', 8),
('bbb', 'b@b.com', '345556566', 'Julieta Herrera Guzmán', 'No aplica', '2021-12-03', '18:00', 'agarcia', 'Cita', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_medico`
--

CREATE TABLE `log_medico` (
  `fecha` date NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `especialidad` varchar(35) NOT NULL,
  `correo` varchar(35) NOT NULL,
  `celular` varchar(10) NOT NULL,
  `eliminado` int(1) NOT NULL,
  `id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `log_medico`
--

INSERT INTO `log_medico` (`fecha`, `nombre`, `especialidad`, `correo`, `celular`, `eliminado`, `id`) VALUES
('2021-12-08', 'Brad Mardueño', 'Cardiología', 'bencinas@gmail.com', '3331998564', 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `nombre` varchar(35) NOT NULL,
  `especialidad` varchar(35) NOT NULL,
  `correo` varchar(35) NOT NULL,
  `celular` varchar(10) NOT NULL,
  `eliminado` int(1) NOT NULL,
  `id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`nombre`, `especialidad`, `correo`, `celular`, `eliminado`, `id`) VALUES
('José Hernández Salazar', 'Cirugía', 'jhernandez@gmail.com', '3354215869', 1, 1),
('Julieta Herrera Guzmán', 'Cardiología', 'jherrera@gmail.com', '3399658742', 1, 2),
('Christian Ibarra Sanz', 'Endocrinología', 'cibarra@gmail.com', '3366985569', 0, 3),
('Juan García Villa', 'Dermatología', 'jvilla@gmail.com', '3320556398', 0, 4),
('Brad Mardueño', 'Cardiología', 'bencinas@gmail.com', '3331998564', 1, 5);

--
-- Disparadores `medico`
--
DELIMITER $$
CREATE TRIGGER `trigger_medico` BEFORE UPDATE ON `medico` FOR EACH ROW INSERT INTO log_medico (fecha, nombre, especialidad, correo, celular, eliminado, id) VALUES (sysdate(), old.nombre, old.especialidad, old.correo, old.celular, old.eliminado, old.id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `nombre` varchar(35) NOT NULL,
  `correo` varchar(35) NOT NULL,
  `usuario` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `privilegios` int(1) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`nombre`, `correo`, `usuario`, `password`, `privilegios`, `id`) VALUES
('Amy García', 'agarcia@gmail.com', 'agarcia', '1234', 1, 1),
('José Solis', 'jsolis@gmail.com', 'jsolis', '1234', 1, 2),
('Christopher Encinas', 'cencinas@gmail.com', 'cencinas', '1234', 0, 3),
('Brad Mardueño', 'bencinas@gmail.com', 'bencinas', '1234', 1, 6),
('Christian Castolo', 'ccastolo@gmai.com', 'ccastolo', '1234', 1, 7),
('Juan García', 'jgarcia@gmail.com', 'jgarcia', '1234', 1, 8),
('a', 'b@b.com', 'b', '123', 1, 9);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cirugia`
--
ALTER TABLE `cirugia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `log_medico`
--
ALTER TABLE `log_medico`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cirugia`
--
ALTER TABLE `cirugia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
