-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-09-2026 a las 04:59:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `concesionario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fo_dpto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id_ciudad`, `nombre`, `fo_dpto`) VALUES
(1, 'bogota', 1),
(2, 'soacha', 1),
(3, 'chia', 1),
(4, 'zipaquira', 1),
(5, 'girardot', 1),
(6, 'medellin', 2),
(7, 'bello', 2),
(8, 'envigado', 2),
(9, 'itagui', 2),
(10, 'rionegro', 2),
(11, 'cali', 3),
(12, 'palmira', 3),
(13, 'buenaventura', 3),
(14, 'tulua', 3),
(15, 'buga', 3),
(16, 'bucaramanga', 4),
(17, 'floridablanca', 4),
(18, 'giron', 4),
(19, 'piedecuesta', 4),
(20, 'barrancabermeja', 4),
(21, 'barranquilla', 5),
(22, 'soledad', 5),
(23, 'malambo', 5),
(24, 'galapa', 5),
(25, 'puerto colombia', 5),
(26, 'cartagena', 6),
(27, 'magangue', 6),
(28, 'turbaco', 6),
(29, 'arjona', 6),
(30, 'el carmen de bolivar', 6),
(31, 'pasto', 7),
(32, 'ipiales', 7),
(33, 'tumaco', 7),
(34, 'la union', 7),
(35, 'samaniego', 7),
(36, 'valledupar', 8),
(37, 'aguachica', 8),
(38, 'bosconia', 8),
(39, 'curumani', 8),
(40, 'la paz', 8),
(41, 'villavicencio', 9),
(42, 'acacias', 9),
(43, 'granada', 9),
(44, 'puerto lopez', 9),
(45, 'san martin', 9),
(46, 'pereira', 10),
(47, 'dosquebradas', 10),
(48, 'santa rosa de cabal', 10),
(49, 'la virginia', 10),
(50, 'marsella', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `identificacion` varchar(50) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fo_ciudad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `identificacion`, `nombre`, `direccion`, `celular`, `email`, `fo_ciudad`) VALUES
(1, '1012456789', 'Carlos Ramírez', 'Cra 45 #12-34', '3004567890', 'carlos.ramirez@gmail.com', 1),
(2, '1023456781', 'Laura Gómez', 'Calle 10 #5-20', '3012345678', 'laura.gomez@hotmail.com', 2),
(3, '1034567892', 'Andrés Torres', 'Av. 7 #23-45', '3023456789', 'andres.torres@yahoo.com', 3),
(4, '1045678903', 'María López', 'Cl 15 #8-90', '3034567890', 'maria.lopez@outlook.com', 4),
(5, '1056789014', 'Juan Pérez', 'Cra 50 #20-10', '3045678901', 'juan.perez@gmail.com', 5),
(6, '1067890125', 'Sofía Martínez', 'Cl 30 #12-50', '3056789012', 'sofia.martinez@gmail.com', 6),
(7, '1078901236', 'Pedro Díaz', 'Cra 80 #45-60', '3067890123', 'pedro.diaz@hotmail.com', 7),
(8, '1089012347', 'Ana Rojas', 'Cl 90 #12-34', '3078901234', 'ana.rojas@gmail.com', 8),
(9, '1090123458', 'Luis Herrera', 'Cra 100 #45-67', '3089012345', 'luis.herrera@yahoo.com', 9),
(10, '1101234569', 'Camila Suárez', 'Cl 110 #23-45', '3090123456', 'camila.suarez@gmail.com', 10),
(11, '1112345670', 'Jorge Medina', 'Cl 20 #10-20', '3101234567', 'jorge.medina@gmail.com', 11),
(12, '1123456781', 'Diana Torres', 'Cra 15 #5-30', '3112345678', 'diana.torres@hotmail.com', 12),
(13, '1134567892', 'Felipe Castro', 'Cl 40 #12-34', '3123456789', 'felipe.castro@gmail.com', 13),
(14, '1145678903', 'Paola Sánchez', 'Cra 60 #45-67', '3134567890', 'paola.sanchez@gmail.com', 14),
(15, '1156789014', 'Ricardo Gómez', 'Cl 70 #23-45', '3145678901', 'ricardo.gomez@gmail.com', 15),
(16, '1167890125', 'Valentina Ruiz', 'Cra 80 #12-34', '3156789012', 'valentina.ruiz@gmail.com', 16),
(17, '1178901236', 'Miguel Ángel', 'Cl 90 #45-67', '3167890123', 'miguel.angel@hotmail.com', 17),
(18, '1189012347', 'Sara Castaño', 'Cra 100 #23-45', '3178901234', 'sara.castano@gmail.com', 18),
(19, '1190123458', 'Daniel López', 'Cl 110 #12-34', '3189012345', 'daniel.lopez@gmail.com', 19),
(20, '1201234569', 'Juliana Vargas', 'Cra 120 #45-67', '3190123456', 'juliana.vargas@gmail.com', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `impuesto` decimal(12,2) NOT NULL,
  `fo_usuario` int(11) NOT NULL,
  `fo_proveedor` int(11) NOT NULL,
  `fo_vehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra`, `fecha`, `cantidad`, `subtotal`, `total`, `impuesto`, `fo_usuario`, `fo_proveedor`, `fo_vehiculo`) VALUES
(1, '2024-04-11', 3, 210000000.00, 249900000.00, 39900000.00, 1, 1, 1),
(2, '2024-05-10', 1, 40000000.00, 47600000.00, 7600000.00, 1, 2, 3),
(3, '2024-07-01', 2, 160000000.00, 190400000.00, 30400000.00, 1, 1, 4),
(4, '2024-03-10', 1, 60000000.00, 71400000.00, 11400000.00, 1, 2, 6),
(5, '2024-08-11', 2, 140000000.00, 166600000.00, 26600000.00, 1, 3, 10),
(6, '2024-10-10', 1, 55000000.00, 65450000.00, 10450000.00, 1, 2, 8),
(7, '2024-10-11', 2, 260000000.00, 309400000.00, 49400000.00, 1, 1, 11),
(8, '2024-07-10', 3, 130000000.00, 154700000.00, 24700000.00, 1, 2, 6),
(9, '2024-08-01', 2, 140000000.00, 166600000.00, 26600000.00, 1, 1, 12),
(10, '2024-05-10', 1, 55000000.00, 65450000.00, 10450000.00, 1, 2, 5),
(11, '2024-04-01', 2, 150000000.00, 178500000.00, 28500000.00, 1, 3, 9),
(12, '2024-11-10', 3, 150000000.00, 178500000.00, 28500000.00, 1, 2, 2),
(14, '2026-09-10', 1, 90000000.00, 107100000.00, 17100000.00, 1, 3, 20),
(15, '2026-09-01', 2, 140000000.00, 166600000.00, 26600000.00, 1, 3, 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dpto`
--

CREATE TABLE `dpto` (
  `id_dpto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fo_pais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `dpto`
--

INSERT INTO `dpto` (`id_dpto`, `nombre`, `fo_pais`) VALUES
(1, 'cundinamarca', 1),
(2, 'antioquia', 1),
(3, 'valle del cauca', 1),
(4, 'santander', 1),
(5, 'atlantico', 1),
(6, 'bolivar', 1),
(7, 'nariño', 1),
(8, 'cesar', 1),
(9, 'meta', 1),
(10, 'risaralda', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `nombre`) VALUES
(1, 'Volskwagen'),
(2, 'Renault');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE `modelo` (
  `id_modelo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `modelo`
--

INSERT INTO `modelo` (`id_modelo`, `nombre`) VALUES
(1, 'Duster'),
(2, 'Gol'),
(3, 'Kwid'),
(4, 'Megane'),
(5, 'Nivus'),
(6, 'Sandero'),
(7, 'Stepway'),
(8, 'Logan'),
(9, 'T-cross'),
(10, 'Taos'),
(11, 'Tiguan'),
(12, 'virtus');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id_pais` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id_pais`, `nombre`) VALUES
(1, 'colombia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posventa`
--

CREATE TABLE `posventa` (
  `id_posventa` int(11) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `fecha_programada` date NOT NULL,
  `estado_servicio` varchar(50) NOT NULL,
  `costo_estimado` decimal(12,2) NOT NULL,
  `costo_final` decimal(12,2) NOT NULL,
  `fo_servicio` int(11) NOT NULL,
  `fo_cliente` int(11) NOT NULL,
  `fo_vehiculo` int(11) NOT NULL,
  `fo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `posventa`
--

INSERT INTO `posventa` (`id_posventa`, `fecha_solicitud`, `fecha_programada`, `estado_servicio`, `costo_estimado`, `costo_final`, `fo_servicio`, `fo_cliente`, `fo_vehiculo`, `fo_usuario`) VALUES
(1, '2025-05-01', '2025-05-03', 'Completado', 120000.00, 115000.00, 1, 1, 1, 2),
(2, '2025-06-10', '2025-06-12', 'Pendiente', 180000.00, 0.00, 2, 2, 2, 2),
(3, '2025-07-05', '2025-07-06', 'Completado', 50000.00, 50000.00, 3, 3, 3, 2),
(4, '2025-07-01', '2025-07-15', 'Completado', 180000.00, 200000.00, 2, 4, 11, 2),
(5, '2025-04-11', '2025-04-12', 'Pendiente', 50000.00, 0.00, 3, 5, 12, 2),
(6, '2025-05-01', '2025-05-03', 'Completado', 120000.00, 115000.00, 1, 6, 7, 2),
(7, '2025-06-10', '2025-06-12', 'Pendiente', 180000.00, 0.00, 2, 7, 9, 2),
(8, '2025-09-21', '2025-09-23', 'Completado', 120000.00, 115000.00, 1, 8, 10, 2),
(9, '2025-08-09', '2025-08-12', 'Pendiente', 180000.00, 0.00, 2, 9, 5, 2),
(10, '2025-11-01', '2025-11-03', 'Completado', 50000.00, 50000.00, 3, 10, 4, 2),
(11, '2025-11-10', '2025-11-12', 'Pendiente', 180000.00, 0.00, 2, 11, 2, 2),
(12, '2025-12-01', '2025-12-03', 'Completado', 120000.00, 115000.00, 1, 12, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nit` varchar(50) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha_registro` date NOT NULL,
  `contacto` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nit`, `razon_social`, `direccion`, `celular`, `email`, `fecha_registro`, `contacto`) VALUES
(1, '900123456-7', 'Autopartes Colombia S.A.', 'Av. 68 #45-90 Bogotá', '3145678901', 'contacto@autopartescol.com', '2023-12-01', 'Luis Herrera'),
(2, '901234567-8', 'Motores del Norte Ltda.', 'Cl 50 #20-10 Medellín', '3156789012', 'ventas@motoresnorte.com', '2023-11-15', 'Sofía Cruz'),
(3, '902345678-9', 'Repuestos del Valle SAS', 'Cra 100 #45-67 Cali', '3167890123', 'info@repuestosvalle.com', '2024-01-10', 'Carlos Rivas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Vendedor'),
(3, 'Técnico'),
(4, 'Usuario'),
(5, 'Invitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `nombre`, `tipo`) VALUES
(1, 'Cambio de aceite', 'Mantenimiento'),
(2, 'Alineación y balanceo', 'Mecánica'),
(3, 'Lavado completo', 'Estética');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test_drive`
--

CREATE TABLE `test_drive` (
  `id_test_drive` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `observaciones` varchar(255) NOT NULL DEFAULT '',
  `fo_cliente` int(11) NOT NULL,
  `fo_modelo` int(11) NOT NULL,
  `fo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `test_drive`
--

INSERT INTO `test_drive` (`id_test_drive`, `fecha`, `observaciones`, `fo_cliente`, `fo_modelo`, `fo_usuario`) VALUES
(1, '2026-09-22 03:46:00', 'Excelente', 1010550633, 10, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `clave` varchar(200) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fo_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `clave`, `celular`, `email`, `fo_rol`) VALUES
(1, 'Juan Pérez', 'admin123', '3101234567', 'juan.perez@concesionario.com', 1),
(2, 'María López', 'ventas2024', '3112345678', 'maria.lopez@concesionario.com', 2),
(3, 'Pedro Díaz', 'tecnico2024', '3123456789', 'pedro.diaz@concesionario.com', 3),
(7, 'Deisy ortiz', 'dei123456', '3107909697', 'wilmarpeg-2011@hotmail.com', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `id_vehiculo` int(11) NOT NULL,
  `serial` varchar(100) NOT NULL,
  `año` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fo_marca` int(11) NOT NULL,
  `fo_modelo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`id_vehiculo`, `serial`, `año`, `color`, `precio`, `fecha_ingreso`, `fo_marca`, `fo_modelo`) VALUES
(1, 'ABC12345', 2025, 'Gris', 93190000.00, '2024-01-15', 2, 1),
(2, 'DEF67890', 2025, 'Plata', 69900000.00, '2024-02-10', 1, 2),
(3, 'GHI11223', 2025, 'Azul Oscuro', 55990000.00, '2024-03-05', 2, 3),
(4, 'JKL44556', 2025, 'Gris', 128500000.00, '2024-04-20', 2, 4),
(5, 'ABC12345', 2025, 'Negro', 79900000.00, '2024-01-15', 1, 12),
(6, 'DEF67890', 2025, 'Plata', 65990000.00, '2024-02-10', 2, 6),
(7, 'GHI11223', 2025, 'Gris', 86630000.00, '2024-03-05', 2, 7),
(8, 'JKL44556', 2025, 'Azul', 67990000.00, '2024-04-20', 2, 8),
(9, 'ABC12345', 2025, 'Amarillo', 99900000.00, '2024-01-15', 1, 9),
(10, 'DEF67890', 2025, 'Cafe', 89900000.00, '2024-02-10', 1, 10),
(11, 'GHI11223', 2025, 'Blanco', 165300000.00, '2024-03-05', 1, 11),
(12, 'JKL44556', 2025, 'Negro', 89900000.00, '2024-04-20', 1, 12),
(16, 'DEF68754', 2025, 'Azul', 200000000.00, '2025-08-13', 2, 4),
(18, 'FFSL8AD23', 2025, 'Rojo', 159000000.00, '2026-09-10', 1, 5),
(19, 'FY8AL82D', 2026, 'Azul', 189000000.00, '2026-09-20', 1, 11),
(20, 'FY8AL82DR', 2026, 'Negro', 90000000.00, '2026-09-20', 2, 1),
(21, 'RG6RH6', 2026, 'Gris', 70000000.00, '2026-09-20', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `subtotales` decimal(12,2) NOT NULL,
  `subtotal_final` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `fo_cliente` int(11) NOT NULL,
  `fo_usuario` int(11) NOT NULL,
  `fo_vehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id_venta`, `fecha`, `cantidad`, `precio`, `subtotales`, `subtotal_final`, `iva`, `total`, `fo_cliente`, `fo_usuario`, `fo_vehiculo`) VALUES
(1, '2024-05-10', 3, 165300000.00, 165300000.00, 165300000.00, 31407000.00, 196707000.00, 1, 2, 11),
(2, '2024-06-15', 1, 69900000.00, 69900000.00, 69900000.00, 13281000.00, 83181000.00, 2, 2, 2),
(3, '2024-07-20', 1, 128500000.00, 128500000.00, 128500000.00, 24415000.00, 152915000.00, 3, 2, 4),
(5, '2026-09-21', 2, 159000000.00, 318000000.00, 318000000.00, 60420000.00, 378420000.00, 16, 2, 18),
(6, '2026-09-22', 1, 77000000.00, 77000000.00, 77000000.00, 14630000.00, 91630000.00, 18, 1, 21);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id_ciudad`),
  ADD KEY `fo_dpto` (`fo_dpto`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `fo_ciudad` (`fo_ciudad`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fo_usuario` (`fo_usuario`),
  ADD KEY `fo_proveedor` (`fo_proveedor`),
  ADD KEY `fo_vehiculo` (`fo_vehiculo`);

--
-- Indices de la tabla `dpto`
--
ALTER TABLE `dpto`
  ADD PRIMARY KEY (`id_dpto`),
  ADD KEY `fo_pais` (`fo_pais`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`id_modelo`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id_pais`);

--
-- Indices de la tabla `posventa`
--
ALTER TABLE `posventa`
  ADD PRIMARY KEY (`id_posventa`),
  ADD KEY `fo_servicio` (`fo_servicio`),
  ADD KEY `fo_cliente` (`fo_cliente`),
  ADD KEY `fo_vehiculo` (`fo_vehiculo`),
  ADD KEY `fo_usuario` (`fo_usuario`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `test_drive`
--
ALTER TABLE `test_drive`
  ADD PRIMARY KEY (`id_test_drive`),
  ADD KEY `fo_cliente` (`fo_cliente`),
  ADD KEY `fo_usuario` (`fo_usuario`),
  ADD KEY `fo_modelo` (`fo_modelo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fo_rol` (`fo_rol`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`id_vehiculo`),
  ADD KEY `fo_marca` (`fo_marca`),
  ADD KEY `fo_modelo` (`fo_modelo`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fo_cliente` (`fo_cliente`),
  ADD KEY `fo_usuario` (`fo_usuario`),
  ADD KEY `fo_vehiculo` (`fo_vehiculo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `dpto`
--
ALTER TABLE `dpto`
  MODIFY `id_dpto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `modelo`
--
ALTER TABLE `modelo`
  MODIFY `id_modelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id_pais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `posventa`
--
ALTER TABLE `posventa`
  MODIFY `id_posventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `test_drive`
--
ALTER TABLE `test_drive`
  MODIFY `id_test_drive` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
