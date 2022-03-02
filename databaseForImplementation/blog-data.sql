-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Mrz 2022 um 13:20
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `blog-data`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments`
--

CREATE TABLE `comments` (
  `id` int(32) NOT NULL,
  `postId` int(32) NOT NULL,
  `title` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `comments`
--

INSERT INTO `comments` (`id`, `postId`, `title`, `text`, `date`) VALUES
(1, 1, 'This is the title of a comment.', 'Text of a comment', '2022-02-17 22:37:00'),
(5, 6, 'This is the title of a comment.', 'Text of a comment', '2022-02-17 22:37:00'),
(7, 1, 'a', 'Text', '2022-02-17 22:37:00'),
(8, 7, 'a', 'Text.', '2022-02-17 22:37:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts`
--

CREATE TABLE `posts` (
  `id` int(32) NOT NULL,
  `title` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `posts`
--

INSERT INTO `posts` (`id`, `title`, `text`, `date`) VALUES
(2, 'This is the updated title.', 'This is the updated text. Test', '2022-02-17 22:37:00'),
(4, 'A title3', 'Some Text', '2022-02-17 22:37:00'),
(6, 'This is a title', 'Some Text. Some more text. Some more text.', '2022-02-17 22:37:00'),
(7, 'A title1', 'Some Text', '2022-02-17 22:37:00'),
(10, 'Title of a new post.', 'Text.', '2022-02-17 22:37:00'),
(11, 'Title of a new post.', 'Text.', '2022-02-17 22:37:00'),
(12, 'This is the text of a new post.', 'Text of a new post.', '2022-02-17 22:37:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(16) NOT NULL,
  `email` varchar(64) NOT NULL,
  `pwd` varchar(64) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `email`, `pwd`, `admin`) VALUES
(85, 'felix@gmail.com', '#SomePassword7#', 1),
(86, 'daniel@gmail.com', '#SomePassword7#', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
