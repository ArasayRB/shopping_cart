-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2020 a las 13:51:24
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shopping_products`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credit_card`
--

CREATE TABLE `credit_card` (
  `number_card` varchar(12) NOT NULL,
  `cvv` int(11) NOT NULL,
  `cash` double NOT NULL,
  `until_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `credit_card`
--

INSERT INTO `credit_card` (`number_card`, `cvv`, `cash`, `until_date`) VALUES
('554756670749', 453, 88.2, '2020-03-28'),
('556672554418', 300, 900, '2023-04-30'),
('564577893241', 767, 200, '2020-10-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `code` varchar(13) NOT NULL,
  `name` varchar(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` double NOT NULL,
  `um` varchar(16) NOT NULL,
  `img` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`code`, `name`, `stock`, `price`, `um`, `img`) VALUES
('1234567890098', 'Apple', 31, 0.3, 'U', 'library/img/apple'),
('1234567890123', 'Beer', 156, 2, 'U', 'library/img/beer'),
('2341567890345', 'Cheese', 305, 3.74, 'Kg', 'library/img/cheese'),
('6789054321567', 'Water', 137, 1, 'U', 'library/img/water');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_cart`
--

CREATE TABLE `product_cart` (
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(13) NOT NULL,
  `shop_id` varchar(6) NOT NULL,
  `cant` int(11) NOT NULL,
  `um` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `product_cart`
--

INSERT INTO `product_cart` (`user_id`, `product_id`, `shop_id`, `cant`, `um`) VALUES
('robe@rb.com', '6789054321567', '666666', 2, 'U');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_clasification`
--

CREATE TABLE `product_clasification` (
  `user_id` varchar(50) NOT NULL,
  `product_id` varchar(13) NOT NULL,
  `clasification` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shop`
--

CREATE TABLE `shop` (
  `codigo` varchar(6) NOT NULL,
  `name` varchar(20) NOT NULL,
  `adress` varchar(150) NOT NULL,
  `email` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `shop`
--

INSERT INTO `shop` (`codigo`, `name`, `adress`, `email`) VALUES
('666666', 'All Shop', 'At 32 Jhonny street betwen Saint Jheremy and Walk City', 'info@allshop.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `email` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `roll` varchar(20) NOT NULL,
  `credit_card` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`email`, `password`, `user_name`, `roll`, `credit_card`) VALUES
('dani@d.com', 'e94d51a35484755a9f9672d13687f499', 'dani', 'user', '564577893241'),
('rafa@di.com', '637af7a9d60d3c9314c6996df1b6e197', 'rafa', 'user', '554756670749'),
('robe@rb.com', 'f86855731b9cd001eabab8d19a44f430', 'robe', 'user', '556672554418');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_pay`
--

CREATE TABLE `user_pay` (
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(13) NOT NULL,
  `shop_id` varchar(6) NOT NULL,
  `cant` int(11) NOT NULL,
  `totall_pay` double NOT NULL,
  `send` text NOT NULL,
  `code_time` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user_pay`
--

INSERT INTO `user_pay` (`user_id`, `product_id`, `shop_id`, `cant`, `totall_pay`, `send`, `code_time`) VALUES
('rafa@di.com', '1234567890098', '666666', 2, 0.6, 'pickUp', '043020134728'),
('rafa@di.com', '1234567890098', '666666', 2, 0.6, 'pickUp', '043020135013'),
('rafa@di.com', '1234567890098', '666666', 2, 0.6, 'ups', '043020135027');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_shops`
--

CREATE TABLE `user_shops` (
  `user_id` varchar(20) NOT NULL,
  `shop_id` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `credit_card`
--
ALTER TABLE `credit_card`
  ADD PRIMARY KEY (`number_card`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `product_cart`
--
ALTER TABLE `product_cart`
  ADD PRIMARY KEY (`user_id`,`product_id`,`shop_id`),
  ADD KEY `shop_id` (`shop_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `product_clasification`
--
ALTER TABLE `product_clasification`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`),
  ADD KEY `credit_card` (`credit_card`);

--
-- Indices de la tabla `user_pay`
--
ALTER TABLE `user_pay`
  ADD PRIMARY KEY (`user_id`,`product_id`,`shop_id`,`code_time`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indices de la tabla `user_shops`
--
ALTER TABLE `user_shops`
  ADD PRIMARY KEY (`user_id`,`shop_id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `product_cart`
--
ALTER TABLE `product_cart`
  ADD CONSTRAINT `product_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_cart_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_cart_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `product_clasification`
--
ALTER TABLE `product_clasification`
  ADD CONSTRAINT `product_clasification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `product_clasification_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`code`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`credit_card`) REFERENCES `credit_card` (`number_card`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_pay`
--
ALTER TABLE `user_pay`
  ADD CONSTRAINT `user_pay_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_pay_ibfk_6` FOREIGN KEY (`product_id`) REFERENCES `products` (`code`),
  ADD CONSTRAINT `user_pay_ibfk_7` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`codigo`);

--
-- Filtros para la tabla `user_shops`
--
ALTER TABLE `user_shops`
  ADD CONSTRAINT `user_shops_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_shops_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
