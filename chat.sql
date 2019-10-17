-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 17 2019 г., 19:17
-- Версия сервера: 5.6.41
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `chat`
--

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `id_room` int(11) NOT NULL DEFAULT '0',
  `id_author_message` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id_message`, `id_room`, `id_author_message`, `message`) VALUES
(1, 1, 1, 'Привет, я админ'),
(2, 1, 2, 'Привет, я пользователь'),
(3, 1, 1, 'fff'),
(4, 1, 2, 'ggg'),
(5, 1, 1, 'Last message'),
(6, 1, 2, 'Yes!!'),
(103, 1, 2, 'Hi!'),
(104, 1, 1, 'Hi!'),
(105, 1, 2, 'll'),
(107, 1, 2, 'Привет'),
(108, 1, 2, 'Как дела?'),
(134, 2, 3, 'jk'),
(135, 2, 2, '54'),
(141, 2, 1, 'Привет, я админ!'),
(142, 4, 1, 'dfsfsfds'),
(143, 4, 2, 'hjuk'),
(145, 2, 1, 'last message'),
(146, 4, 1, 'ee'),
(158, 1, 1, 'Хорошо'),
(159, 1, 1, 'dsf'),
(160, 1, 2, 'asd'),
(161, 1, 2, 'dsada'),
(162, 1, 1, 'dadsa'),
(163, 1, 2, 'fsdsf');

-- --------------------------------------------------------

--
-- Структура таблицы `participants`
--

CREATE TABLE `participants` (
  `id_participant` int(11) NOT NULL,
  `id_room` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `participants`
--

INSERT INTO `participants` (`id_participant`, `id_room`, `id_user`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 2, 3),
(5, 2, 1),
(6, 4, 1),
(7, 4, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

CREATE TABLE `rooms` (
  `id_room` int(11) NOT NULL,
  `name_room` varchar(50) DEFAULT NULL,
  `type_user` int(11) NOT NULL DEFAULT '0',
  `id_author_room` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `rooms`
--

INSERT INTO `rooms` (`id_room`, `name_room`, `type_user`, `id_author_room`) VALUES
(1, 'room1', 1, 1),
(2, 'room2', 1, 2),
(4, 'room4', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `login` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '0',
  `hash` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `login`, `password`, `hash`) VALUES
(1, 'admin', 'admin', 'hhh'),
(2, 'user', 'user', 'aaa'),
(3, 'user3', 'user3', 'aaa3');

-- --------------------------------------------------------

--
-- Структура таблицы `userstypes`
--

CREATE TABLE `userstypes` (
  `id_type` int(11) NOT NULL,
  `type_user` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `userstypes`
--

INSERT INTO `userstypes` (`id_type`, `type_user`) VALUES
(1, 'Владелец'),
(2, 'Собеседник');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`);

--
-- Индексы таблицы `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id_participant`);

--
-- Индексы таблицы `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id_room`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Индексы таблицы `userstypes`
--
ALTER TABLE `userstypes`
  ADD PRIMARY KEY (`id_type`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT для таблицы `participants`
--
ALTER TABLE `participants`
  MODIFY `id_participant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id_room` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `userstypes`
--
ALTER TABLE `userstypes`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
