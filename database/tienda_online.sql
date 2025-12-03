-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2025 a las 21:37:34
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
-- Base de datos: `tienda_online`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `id_usuario`, `total`) VALUES
(1, 1, 998.00),
(2, 2, 1548.00),
(3, 3, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_detalle`
--

CREATE TABLE `carrito_detalle` (
  `id_carrito_detalle` int(11) NOT NULL,
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `carrito_detalle`
--

INSERT INTO `carrito_detalle` (`id_carrito_detalle`, `id_carrito`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(3, 2, 2, 1, 1299.00, 1299.00),
(4, 2, 8, 1, 299.00, 299.00),
(15, 1, 15, 2, 499.00, 998.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_producto`
--

CREATE TABLE `categoria_producto` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categoria_producto`
--

INSERT INTO `categoria_producto` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Electrónica', 'Dispositivos electrónicos como teléfonos, audífonos, bocinas y accesorios.'),
(2, 'Ropa', 'Ropa para hombre, mujer y niños. Incluye camisetas, pantalones y más.'),
(3, 'Hogar', 'Productos y artículos para el hogar, limpieza y decoración.'),
(4, 'Accesorios', 'Artículos pequeños como relojes, cinturones, carteras y gafas.'),
(5, 'Juguetes', 'Juguetes para niños, educativos, de colección y electrónicos.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pedido`
--

CREATE TABLE `estado_pedido` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `estado_pedido`
--

INSERT INTO `estado_pedido` (`id_estado`, `nombre_estado`) VALUES
(1, 'Pendiente'),
(2, 'Procesando'),
(3, 'Enviado'),
(4, 'Entregado'),
(5, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_pedidos`
--

CREATE TABLE `historial_pedidos` (
  `id_historial` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `historial_pedidos`
--

INSERT INTO `historial_pedidos` (`id_historial`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(1, 1, 1, 1, 899.99, 899.99),
(2, 1, 3, 2, 199.50, 399.00),
(3, 2, 2, 1, 1299.00, 1299.00),
(4, 2, 8, 1, 299.00, 299.00),
(5, 5, 1, 2, 899.99, 1799.98),
(6, 5, 3, 6, 199.50, 1197.00),
(7, 5, 19, 2, 149.00, 298.00),
(8, 6, 14, 4, 899.00, 3596.00),
(9, 7, 19, 3, 149.00, 447.00),
(10, 8, 9, 3, 899.00, 2697.00),
(11, 9, 18, 5, 199.00, 995.00),
(12, 9, 17, 10, 249.00, 2490.00),
(13, 10, 3, 10, 199.50, 1995.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `id_metodoPago` int(11) NOT NULL,
  `nombre_pago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `metodo_pago`
--

INSERT INTO `metodo_pago` (`id_metodoPago`, `nombre_pago`) VALUES
(1, 'Tarjeta de Crédito'),
(2, 'Tarjeta de Débito'),
(3, 'Pago en OXXO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_metodoPago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `id_usuario`, `fecha_pedido`, `total`, `id_estado`, `id_metodoPago`) VALUES
(1, 1, '2025-01-25 14:30:00', 1298.99, 4, 1),
(2, 2, '2025-01-26 09:45:00', 1598.00, 2, 3),
(5, 1, '2025-11-30 15:08:13', 3294.98, 1, 1),
(6, 1, '2025-11-30 15:09:53', 3596.00, 1, 1),
(7, 3, '2025-11-30 17:11:00', 447.00, 1, 1),
(8, 3, '2025-11-30 17:14:34', 2697.00, 1, 1),
(9, 3, '2025-12-02 14:45:25', 3485.00, 1, 1),
(10, 3, '2025-12-03 09:15:39', 1995.00, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `descripcion`, `precio`, `stock`, `imagen`, `id_categoria`) VALUES
(1, 'Auriculares Bluetooth', 'Auriculares inalámbricos con cancelación de ruido.', 899.99, 33, 'auriculares.jpg', 1),
(2, 'Smartwatch FitPro X', 'Reloj inteligente resistente al agua con monitoreo de salud.', 1299.00, 20, 'smartwatch.jpg', 1),
(3, 'Camiseta Negra Unisex', 'Camiseta básica de algodón, cómoda y ligera.', 199.50, 44, 'camiseta_negra.jpg', 2),
(4, 'Pantalón Deportivo', 'Pants deportivos unisex, tela suave y elástica.', 349.99, 40, 'pantalon_deportivo.jpg', 2),
(5, 'Lámpara de Escritorio LED', 'Lámpara ajustable con luz cálida y fría.', 249.00, 25, 'lampara_led.jpg', 3),
(6, 'Juego de Sábanas Queen', 'Juego de sábanas suaves 100% microfibra.', 499.00, 15, 'sabanas_queen.jpg', 3),
(7, 'Reloj Casual de Piel', 'Reloj con correa de piel sintética, diseño elegante.', 699.00, 18, 'reloj_piel.jpg', 4),
(8, 'Lentes de Sol Vintage', 'Gafas estilo retro con protección UV400.', 299.00, 50, 'lentes_vintage.jpg', 4),
(9, 'Robot RC Explorer', 'Robot a control remoto con luces y sonidos.', 899.00, 9, 'robot_rc.jpg', 5),
(10, 'Set de Bloques Creativos', 'Bloques armables para niños de +5 años.', 349.00, 30, 'bloques_creativos.jpg', 5),
(11, 'Bocina Portátil JBL Mini', 'Bocina bluetooth resistente al agua, batería de 10 horas.', 749.00, 25, 'bocina_jbl.jpg', 1),
(12, 'Teclado Mecánico RGB', 'Teclado mecánico con iluminación RGB y switches Blue.', 899.00, 18, 'teclado_rgb.jpg', 1),
(13, 'Sudadera Unisex Gris', 'Sudadera ligera con cierre y capucha.', 399.00, 30, 'sudadera_gris.jpg', 2),
(14, 'Tenis Deportivos Runner X', 'Tenis ligeros para correr, suela antiderrapante.', 899.00, 16, 'tenis_runner.jpg', 2),
(15, 'Cafetera Compacta 4 Tazas', 'Cafetera compacta diseñada para uso diario.', 499.00, 15, 'cafetera_compacta.jpg', 3),
(16, 'Set de Utensilios de Cocina 12pz', 'Incluye espátulas, cucharones y pinzas de silicón.', 329.00, 40, 'utensilios_cocina.jpg', 3),
(17, 'Cartera Slim Antirrobo', 'Cartera delgada con protección RFID.', 249.00, 40, 'cartera_slim.jpg', 4),
(18, 'Pulsera de Acero Negra', 'Pulsera elegante resistente al agua.', 199.00, 40, 'pulsera_negra.jpg', 4),
(19, 'Pelota Sensorial LED', 'Pelota con luces LED para niños, rebote suave.', 149.00, 55, 'pelota_led.jpg', 5),
(20, 'Drone Mini Flyer', 'Mini dron con control remoto y estabilizador.', 1099.00, 10, 'drone_mini.jpg', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_destacado`
--

CREATE TABLE `producto_destacado` (
  `id_destacado` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `fecha_asignacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `producto_destacado`
--

INSERT INTO `producto_destacado` (`id_destacado`, `id_producto`, `fecha_asignacion`) VALUES
(1, 1, '2025-01-10'),
(2, 3, '2025-01-12'),
(3, 6, '2025-01-15'),
(4, 10, '2025-01-20'),
(5, 11, '2025-02-01'),
(6, 13, '2025-02-03'),
(7, 16, '2025-02-05'),
(8, 20, '2025-02-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `contraseña` varchar(200) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `dirrecion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `email`, `contraseña`, `telefono`, `dirrecion`) VALUES
(1, 'Carlos', 'Hernández', 'carlos.hdz@example.com', 'Passw0rd123', '5544332211', 'Av. Reforma #102, CDMX'),
(2, 'Mariana', 'López', 'mariana.lopez@example.com', 'Mari2024!', '5533667788', 'Calle Gardenias #55, Puebla'),
(3, 'Pedro', 'Ake', 'pedroake@gmail.com', '123456', '9057352677', 'av.lopez portillo calle 23'),
(4, 'josueh', 'hernandez', 'josue@gmail.com', 'hernandez', 'RRRRRRRRR', 'Av. parque coco calle 23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  ADD PRIMARY KEY (`id_carrito_detalle`),
  ADD KEY `id_carrito` (`id_carrito`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `estado_pedido`
--
ALTER TABLE `estado_pedido`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `historial_pedidos`
--
ALTER TABLE `historial_pedidos`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`id_metodoPago`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_metodoPago` (`id_metodoPago`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `producto_destacado`
--
ALTER TABLE `producto_destacado`
  ADD PRIMARY KEY (`id_destacado`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  MODIFY `id_carrito_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estado_pedido`
--
ALTER TABLE `estado_pedido`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `historial_pedidos`
--
ALTER TABLE `historial_pedidos`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `id_metodoPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `producto_destacado`
--
ALTER TABLE `producto_destacado`
  MODIFY `id_destacado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  ADD CONSTRAINT `carrito_detalle_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`),
  ADD CONSTRAINT `carrito_detalle_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `historial_pedidos`
--
ALTER TABLE `historial_pedidos`
  ADD CONSTRAINT `historial_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `historial_pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado_pedido` (`id_estado`),
  ADD CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`id_metodoPago`) REFERENCES `metodo_pago` (`id_metodoPago`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_producto` (`id_categoria`);

--
-- Filtros para la tabla `producto_destacado`
--
ALTER TABLE `producto_destacado`
  ADD CONSTRAINT `producto_destacado_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
