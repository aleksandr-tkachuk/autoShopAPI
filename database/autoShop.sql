-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 15 2017 г., 18:37
-- Версия сервера: 5.7.16
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `autoShop`
--
CREATE DATABASE IF NOT EXISTS `autoShop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `autoShop`;

-- --------------------------------------------------------

--
-- Структура таблицы `auto`
--

DROP TABLE IF EXISTS `auto`;
CREATE TABLE `auto` (
  `id` int(11) NOT NULL,
  `model` varchar(100) NOT NULL,
  `brands` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `engine` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `kpp` varchar(50) NOT NULL,
  `speed` int(11) NOT NULL,
  `price` float(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auto`
--

INSERT INTO `auto` (`id`, `model`, `brands`, `year`, `engine`, `color`, `kpp`, `speed`, `price`) VALUES
(1, '1', 'ASTRA', 2005, '2.2', 'white', 'auto', 180, 23000.00),
(2, '1', 'VECTRA', 2013, '2.0', 'red', 'manual', 200, 18000.00),
(3, '2', 'A6', 2005, '2.2', 'white', 'auto', 220, 13000.00),
(4, '3', '320AMG', 2013, '2.0', 'red', 'manual', 200, 5000.00);

-- --------------------------------------------------------

--
-- Структура таблицы `models`
--

DROP TABLE IF EXISTS `models`;
CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `models`
--

INSERT INTO `models` (`id`, `name`) VALUES
(1, 'audi'),
(2, 'opel'),
(3, 'bmw'),
(4, 'Kia');

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `auto` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `user`, `auto`, `date`) VALUES
(1, '1', '1', '2017-10-10 15:32:48'),
(6, '2', '1', '2017-10-12 17:07:08'),
(7, '2', '1', '2017-10-12 17:07:09'),
(8, '2', '1', '2017-10-12 17:07:09'),
(9, '2', '1', '2017-10-12 17:07:10');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `name`, `token`) VALUES
(1, 'user1', '698d51a19d8a121ce581499d7b701668', 'User 1', 'dBX45rbMvR5pu8c'),
(2, 'user2', 'bcbe3365e6ac95ea2c0343a2395834dd', 'User 2', '8qRMqLAUF2nbqr0');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auto`
--
ALTER TABLE `auto`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `auto`
--
ALTER TABLE `auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
